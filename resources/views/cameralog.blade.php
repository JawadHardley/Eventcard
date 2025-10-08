@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <div class="card bg-base-100 p-10 border-2 border-indigo-500">
                <figure class="p-10">
                    <i class="fa fa-camera text-9xl inline"></i>
                </figure>
                <div id="reader" style="width: 320px; margin: auto; border-radius: 12px; overflow: hidden;"></div>
                <div class="card-body items-center text-center">
                    <p>If you already have your gestlist ready and accurate, fire the camera button and lets get scanning
                    </p>
                    <div class="card-actions pt-10">
                        <button id="startCamera" class="btn btn-outline btn-primary">Activate Camera</button>
                        <button id="stopCamera" class="btn btn-secondary">Activate Camera</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="module">
        const html5QrCode = new Html5Qrcode("reader");

        document.getElementById("startCamera").addEventListener("click", async () => {
            try {
                const cameras = await Html5Qrcode.getCameras();

                if (cameras && cameras.length) {
                    const cameraId = cameras[0].id;

                    await html5QrCode.start(
                        cameraId, {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            }
                        },
                        (decodedText) => console.log("QR Detected:", decodedText),
                        (errorMsg) => console.warn("Scanning error:", errorMsg)
                    );
                }
            } catch (err) {
                console.error("Camera error:", err);
                alert("Could not access camera 😢");
            }
        });

        document.getElementById("stopCamera").addEventListener("click", () => {
            html5QrCode.stop().then(() => {
                console.log("Camera stopped");
            }).catch(err => console.error("Stop failed", err));
        });
    </script>
@endsection
