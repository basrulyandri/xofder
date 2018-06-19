@extends('layouts.emails.master')

@section('content')
	<td valign="top" class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #202020;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;">
                        
                            <h1 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 26px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;">Assalamualaikum, </h1>

							

                            <p style="margin: 10px 0;padding: 0;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #202020;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;">Sistem kami baru saja mendapatkan permintaan reset password untuk akun {{toBapakOrIbu($user->anggota->gender)}} atas nama {{$user->anggota->nama}}. Berikut ini link untuk merubah password :</p>                            

                            <a href="{{route('reset.password',['reset_password_code' => $user->reset_password_code])}}">{{route('reset.password',['reset_password_code' => $user->reset_password_code])}}</a>
                            
                        </td>
@stop