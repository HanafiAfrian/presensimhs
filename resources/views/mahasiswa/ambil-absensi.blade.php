@extends('layouts.app')

@push('menu-active-ambilperkuliahan', 'active')

@section('title', 'Ambil Absensi Perkuliahan')
@section('content-title', 'Ambil Absensi Perkuliahan')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <section class="content">
                        <div class="container-fluid">
                            <form method="POST">
                                @csrf
                                <div class="row">
                                    <?php
                                    if ($user instanceof \stdClass) {
                                        $user = (array) $user;
                                    }
                                    ?>
                                    <div class="col-md-6">
                                        <center>
                                            <video id="previewKamera" style="width: 600px;height: 600px;"></video>
                                            <br>
                                            <input type="hidden" id="hasilscan">
                                            <br>
                                            <div id="jsonResult"></div>
                                        </center>
                                        <div class="form-group">
                                            <ul>
                                                <li>NIM: {{ $user['mhsNim'] }}</li>
                                                <li>Nama: {{ $user['mhsNama'] }}</li>
                                                <li>Jenis Kelamin: {{ $user['mhsJenkel'] }}</li>
                                                <li>Angkatan: {{ $user['mhsAngkatan'] }}</li>
                                                <li>Program Studi: {{ $user['mhsProdiNama'] }}</li>
                                                <li>Fakultas: {{ $user['mhsFakNama'] }}</li>
                                                <li>Level: {{ $user['level'] }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Anda bisa menambahkan form input atau elemen lain di sini -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
    <script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>
        let selectedDeviceId = null;
        const codeReader = new ZXing.BrowserMultiFormatReader();
        const sourceSelect = $("#pilihKamera");

        $(document).on('change','#pilihKamera',function(){
            selectedDeviceId = $(this).val();
            if(codeReader){
                codeReader.reset();
                initScanner();
            }
        });

        function initScanner() {
            codeReader
            .listVideoInputDevices()
            .then(videoInputDevices => {
                videoInputDevices.forEach(device =>
                    console.log(`${device.label}, ${device.deviceId}`)
                );

                if(videoInputDevices.length > 0){
                    if(selectedDeviceId == null){
                        if(videoInputDevices.length > 1){
                            selectedDeviceId = videoInputDevices[1].deviceId;
                        } else {
                            selectedDeviceId = videoInputDevices[0].deviceId;
                        }
                    }

                    if (videoInputDevices.length >= 1) {
                        sourceSelect.html('');
                        videoInputDevices.forEach((element) => {
                            const sourceOption = document.createElement('option');
                            sourceOption.text = element.label;
                            sourceOption.value = element.deviceId;
                            if(element.deviceId == selectedDeviceId){
                                sourceOption.selected = 'selected';
                            }
                            sourceSelect.append(sourceOption);
                        });
                    }

                    codeReader
                        .decodeOnceFromVideoDevice(selectedDeviceId, 'previewKamera')
                        .then(result => {
                                console.log(result.text);
                                $("#hasilscan").val(result.text);
                                $("#mhsNim").val(result.text);

                                $.ajax({
                                    type: 'POST',
                                    url: '{{ route("mhs.qr.receive") }}',  
                                    data: {
                                        _token: '{{ csrf_token() }}',  
                                        qr: result.text,
                                        mhsNim: {{ $user['mhsNim'] }}
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        console.log(response.message);
                                        $("#jsonResult").html(`<pre>${JSON.stringify(response, null, 2)}</pre>`);

                                        // Parse qr and create combined JSON
                                        const combinedResult = {
                                            mhsNim: response.mhsNim,
                                            fakid: response.fakid,
                                            kelasid: response.kelasid
                                        };

                                        $("#jsonResult").html(`<pre>${JSON.stringify(combinedResult, null, 2)}</pre>`);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error:', status, error);
                                    }
                                });

                                if(codeReader){
                                    codeReader.reset();
                                }
                        })
                        .catch(err => console.error(err));
                } else {
                    alert("Camera not found!");
                }
            })
            .catch(err => console.error(err));
        }

        if (navigator.mediaDevices) {
            initScanner();
        } else {
            alert('Cannot access camera.');
        }
    </script>
@endsection
