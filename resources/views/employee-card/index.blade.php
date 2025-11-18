@extends('layouts.admin')



@section('page-title', 'Employee Cards')
@section('content')
<div class="container my-4">


    {{-- Employee Selection Dropdown --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5>Select Employee</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('employee.card.index') }}">
                <div class="form-group">
                    <label for="employeeSelect">Choose Employee:</label>
                    <select name="employee" id="employeeSelect" class="form-control" onchange="this.form.submit()">
                        <option value="">Select an employee...</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ request('employee') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }} ({{ $emp->employee_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- Employee Card Display - Only show when employee is selected --}}
    @if($employee)
    <div class="card-wrapper"
         style="width:360px;height:550px;border-radius:10px;overflow:hidden;
                box-shadow:0 6px 18px rgba(0,0,0,0.15);display:block;margin:0 auto;position:relative;
                background-image: url('{{ asset('images/idcard-bg.png') }}');
                background-size: cover; background-repeat: no-repeat; background-position: -10px;">

        {{-- Top header --}}
        <div style="background:#1d67a3;color:#fff;padding:10px 12px;display:flex;flex-direction:column;align-items:center;text-align:center;">
            <div style="font-weight:700;font-size:18px;letter-spacing:1px;line-height:13px;">
                {{ config('app.company_name','BITMAX TECHNOLOGY PVT LTD') }}
            </div>
            <div style="font-size:11px;opacity:0.95;margin-top:4px;line-height:1.3;padding-inline:30px;">
                {{ config('app.company_address','Bhutani Alphathum Tower C, Unit-1034, Floor 10th, Noida - 201304') }}
            </div>
            <div style="font-size:11px;opacity:0.95;margin-top:4px;line-height:1.3;padding-inline:30px;">
                IVR: {{ config('app.company_ivr','924234234234234') }}
            </div>
            <div style="font-size:11px;opacity:0.95;margin-top:4px;line-height:1.3;padding-inline:30px;">
                E: {{ config('app.company_email','info@bitmaxtechnology.com') }}
            </div>
            <div style="font-size:11px;opacity:0.95;margin-top:4px;line-height:1.3;padding-inline:30px;">
                W: {{ config('app.company_website','www.bitmaxgroup.com') }}
            </div>
        </div>

        {{-- Photo + Name + Logo row --}}
        <div style="display:flex;padding:16px 18px 10px 18px;">
            <div style="width:300px;text-align:center;">
                <div style="font-size:14px;font-weight:bold;color:#1d67a3;margin-bottom:5px;margin-left:35px;">IDENTITY CARD</div>
                <div style="display:flex;flex-direction:row;align-items:center;justify-content:center;gap:10px;">
                    <div style="font-size:18px;font-weight:bold;color:#111;writing-mode:vertical-rl;text-orientation:mixed;transform:rotate(180deg);white-space:nowrap;">
                        {{ $employee->validity ?? '2024-2026' }}
                    </div>
                    <div style="width:150px;height:180px;border:2px solid #111;background:#eee;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                        <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="Photo"
                             style="width:100%;height:100%;object-fit:cover;display:block;" />
                    </div>
                    
                </div>
                <div style="background-color:rgb(209,209,209);margin-top:3px;margin-left:35px; padding:2px 10px;border-radius:5px;">
                    <div style="margin-top:10px;font-weight:800;font-size:16px;color:#111;">
                        {{ strtoupper($employee->name) }}
                    </div>
                    <div style="font-size:10px;font-weight:600;color:#444;margin-top:2px;">
                        {{ strtoupper($employee->position) }}
                    </div>
                </div>
            </div>

            <div style="display:flex;align-items:center;justify-content:center;">
               
                    <img src="https://www.bitmaxgroup.com/assets/logo/logo.png" alt="Logo"
                         style="width:120px;height:auto;object-fit:contain" />
              
            </div>
        </div>

        {{-- Info block --}}
        <div style="padding:8px 20px 20px 150px;display:block;">
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                <div style="font-size:10px;font-weight:900;color:#333;">EC NO</div>
                <div style="font-size:10px;font-weight:900;color:#111;">: {{ $employee->employee_code }}</div>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                <div style="font-size:10px;font-weight:900;color:#333;">Blood Group</div>
                <div style="font-size:10px;font-weight:900;color:#111;">-</div>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                <div style="font-size:10px;font-weight:900;color:#333;">DOB</div>
                <div style="font-size:10px;font-weight:900;color:#111;">: {{ $employee->dob ? $employee->dob->format('Y-m-d') : 'N/A' }}</div>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:8px;">
                <div style="font-size:10px;font-weight:900;color:#333;">MOBILE</div>
                <div style="font-size:10px;font-weight:900;color:#111">: {{ $employee->phone }}</div>
            </div>
        </div>

        {{-- Bottom watermark --}}
        <div style="position:absolute;right:10px;bottom:0px;width:100%;padding:6px 14px;display:flex;justify-content:flex-end;align-items:center;opacity:0.2;">
            <img src="https://www.bitmaxgroup.com/assets/logo/logo.png" alt="Logo"
                 style="width:180px;height:auto;object-fit:contain" />
        </div>
    </div>

    {{-- <div class="text-center mt-3">
        <a href="{{ route('employee.card.pdf', $employee->id) }}" class="btn btn-success">Download PDF</a>
    </div> --}}
    @endif

</div>
@endsection