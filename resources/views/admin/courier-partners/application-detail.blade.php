@extends('admin.main-frame')
@section('custome_style')
    <style>
        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #f41909;
            border-bottom: 2px solid #f41909;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .profile-picture {
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            object-fit: fill;
            object-position: center;
            margin-bottom: 20px;
        }

        .resume-card {
            border: 2px solid #f41909;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
        }

        .resume-card img {
            width: 50px;
            height: 50px;
        }

        .resume-card .file-details {
            margin-left: 15px;
        }

        .resume-card .file-details p {
            margin: 0;
        }
    </style>
@endsection
@section('admin_body')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">Application</span> Detail</h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <div class="card-body">
                        <div class="text-center">
                            <img id="profilePicturePreview" class="profile-picture"
                                src="{{ $user->profilePicture ? asset('uploads/profile_picture/' . $user->profilePicture) : 'https://via.placeholder.com/150' }}"
                                alt="Profile Picture">
                        </div>

                        <div class="mb-4">
                            <h3 class="section-title">Personal Information</h3>
                            <p><strong>Name:</strong> {{ $user->fullName }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Phone Number:</strong> {{ $user->phone }}</p>
                            <p><strong>Address:</strong> {{ $user->address }}</p>
                            <p><strong>DOB:</strong> {{ $user->dob }}</p>
                        </div>
                        <div class="mb-4">
                            <h3 class="section-title">Vehicle Information</h3>
                            <p><strong>Type:</strong> {{ $user->vehicleType }}</p>
                            <p><strong>License Number:</strong> {{ $user->licenseNumber }}</p>
                            <p><strong>License Expiry:</strong> {{ $user->licenseExpiry }}</p>
                            <p><strong>National Id:</strong> {{ $user->nationalId }}</p>
                        </div>

                        <div class="mb-4">
                            <h3 class="section-title">Availability</h3>
                            @if (isset($user->workingDays) && !empty($user->workingDays) && json_decode($user->workingDays) != null)
                                @php
                                    $workDays = json_decode($user->workingDays);
                                @endphp
                                @foreach ($workDays as $workDay)
                                    <div class="p-2 " style="border-bottom: 1px solid #ddd;">
                                        <p class="text-capitalize "><strong>Available Working Days:</strong>
                                            {{ $workDay->day }} - ({{ date('h:i A', strtotime($workDay->start_time)) }} to {{ date('h:i A', strtotime($workDay->end_time)) }})</p>
                                        
                                    </div>
                                @endforeach
                            @endif

                            <p><strong>Working Experience:</strong> {{ $user->experience }}</p>
                        </div>
                        <div class="mb-4">
                            <h3 class="section-title">Reference</h3>
                            <p class="text-capitalize "><strong>Name:</strong> {{ $user->experience }}</p>
                            <p class="text-capitalize "><strong>Reference Contact:</strong> {{ $user->referenceContact }}
                            </p>
                        </div>

                        @if ($user->resume)
                            <div class="resume-card">
                                <h3 class="section-title">Resume</h3>
                                <div class="d-flex align-items-center">
                                    <a download="resume" href="{{ asset('uploads/resumes/' . $user->resume) }}">Download
                                        Resume</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                        <div class="col-12 mb-0">
                            <div class="alert alert-warning">
                                <h6 class="alert-heading mb-1">Are you sure you want to delete your account?</h6>
                                <p class="mb-0">Once you delete your account, there is no going back. Please be certain.
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('admin.delete.vendor') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-check mb-3">

                                <input class="form-check-input" type="checkbox" name="accountActivation"
                                    id="accountActivation" />

                                <label class="form-check-label" for="accountActivation">I confirm my account
                                    deactivation</label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                        </form>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
@section('custome_script')
@endsection
