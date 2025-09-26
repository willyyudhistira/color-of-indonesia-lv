<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your E-Certificate for {{ $participant->event->title }}</title>
    <style>
        /* CSS ini hanya untuk fallback, styling utama ada di inline CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f5f7;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        @media screen and (max-width: 600px) {
            .content-cell {
                padding: 20px !important;
            }
            .button {
                padding: 14px 24px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f5f7; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">

    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f4f5f7;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                
                <table class="container" width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    
                    <tr>
                        <td align="center" style="padding: 30px 20px; border-bottom: 1px solid #eeeeee;">
                            {{-- Ganti 'URL_LOGO_ANDA' dengan URL logo perusahaan/event Anda --}}
                            <img src="{{ asset('assets/images/logo_coi.png') }}" alt="Logo Event" style="max-width: 150px; height: auto;">
                        </td>
                    </tr>

                    <tr>
                        <td class="content-cell" style="padding: 40px 30px;">
                            <h1 style="font-size: 24px; font-weight: 600; color: #333333; margin-top: 0; margin-bottom: 20px;">
                                Your E-Certificate is Ready!
                            </h1>
                            <p style="font-size: 16px; color: #555555; line-height: 1.6; margin: 0 0 15px;">
                                Halo, <strong>{{ $participant->name }}</strong>!
                            </p>
                            <p style="font-size: 16px; color: #555555; line-height: 1.6; margin: 0 0 25px;">
                                Thank you for participating in the <strong>{{ $participant->event->title }}</strong>. As a symbol of our appreciation, we have prepared an e-certificate for you.
                            
                            <p style="font-size: 16px; color: #555555; line-height: 1.6; margin: 0 0 10px;">
                                Use the unique number below to download your certificate:
                            </p>
                            <div style="background-color: #f9f9f9; border: 1px dashed #dddddd; border-radius: 8px; padding: 20px; text-align: center; margin-bottom: 30px;">
                                <p style="font-size: 22px; font-weight: bold; color: #8a2be2; font-family: 'Courier New', Courier, monospace; margin: 0; letter-spacing: 2px;">
                                    {{ $participant->certificate_number }}
                                </p>
                            </div>

                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('e-certificate.index') }}" target="_blank" class="button" style="display: inline-block; background-color: #8a2be2; color: #ffffff; font-size: 16px; font-weight: bold; text-decoration: none; padding: 16px 32px; border-radius: 8px; transition: background-color 0.3s;">
                                            Download E-Certificate Here
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 20px 30px; background-color: #f1e7fe; border-top: 1px solid #eeeeee;">
                            <p style="font-size: 12px; color: #8a2be2; margin: 0;">
                                © {{ date('Y') }} Color of Indonesia. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>