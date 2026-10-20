@props(['url'])
{{-- Yalla Courier logo for every Laravel mail/notification (published from the framework 2026-10-20).
     PNG, not SVG: Gmail and Outlook don't render SVG. URL set by MAIL_LOGO_URL (config/mail.php "logo_url"). --}}
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ config('mail.logo_url') }}" width="140" height="66" alt="{{ config('app.name') }}" style="width:140px;height:auto;max-height:66px;border:0;">
</a>
</td>
</tr>
