<div>
    We have received a new offer contact<br /><br />

    Email from: {{$data['name']}}<br />
    Email address: {{$data['email']}}<br />
    Phone: {{$data['phone']}}<br />

    @if(isset($data['company_name']))
        Compnay Name: {{$data['company_name']}}<br />
    @endif
    @if(isset($data['no_of_employee']))
        No of Employee's: {{$data['no_of_employee']}}<br /><br />
    @endif

    Please get to work!!<br />
</div>
