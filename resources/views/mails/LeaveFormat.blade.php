<x-mail::message>
This is regarding your leave status.

You have applied for leave from {{ $start_date }} to {{ $end_date }}.

Your current Leave status: {{ $leave_status }}

Thanks, <br>
{{ config('app.name') }}
</x-mail::message>