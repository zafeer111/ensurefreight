@component('mail::message')
# Inquiry Generated Successfully!

Dear {{ $inquiry->customerUser->name }},

<x-mail::panel>
Your inquiry Reference No: {{ $inquiry->referenceNo->reference_no }} has been successfully created. Our team will review it and get back to you shortly.
</x-mail::panel>

Thank you for reaching out to us!

<x-mail::button :url="route('inquiries.show', $inquiry->id)" color="success">
View Inquiry
</x-mail::button>

Regards,<br>
{{ config('app.name') }}


<x-mail::footer>
<div class="footer-wrap pd-20 mb-20 card-box">
    <a target="_blank" style="color: red; text-decoration: none;" href="https://www.ensurefreightinc.com/">Ensure Freight Inc</a>- OnlineApp, <br/>
    <span class="italic small">Powered by</span>
    <a class="small" href="https://widewebartisans.com/" target="_blank">Wide Web Artisans</a>
</div>
</x-mail::footer>

@endcomponent