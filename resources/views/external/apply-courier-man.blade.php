@extends('external.frame')
@section('external-css')
    <style>
        :root {
            --primary-red: red;
            --dark-red: #c0392b;
            --light-red: #ff6b6b;
            --accent-gold: #f1c40f;
            --text-dark: #2c3e50;
            --text-light: #ecf0f1;
            --bg-light: #fff5f5;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .application-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(231, 76, 60, 0.1);
            overflow: hidden;
            margin: 3rem auto;
            position: relative;
        }

        .application-header {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--dark-red) 100%);
            padding: 2rem;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .application-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.1)" d="M0,0 L100,0 L100,100 L0,100 Z" /></svg>');
            background-size: cover;
            opacity: 0.2;
        }

        .application-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .application-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            position: relative;
        }

        .form-section {
            padding: 2rem;
            border-bottom: 1px solid #eee;
        }

        .form-section:last-child {
            border-bottom: none;
        }

        .form-section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-red);
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .form-section-title::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-red);
        }

        .form-group label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.2);
            outline: none;
        }

        .invalid-feedback {
            color: var(--primary-red);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .is-invalid {
            border-color: var(--primary-red) !important;
        }

        .btn-primary {
            background-color: var(--primary-red);
            border: none;
            border-radius: 8px;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            width: 100%;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-primary:hover {
            background-color: var(--dark-red);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Profile Picture Upload */
        .profile-picture-wrapper {
            text-align: center;
            margin: 2rem 0;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-red);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .profile-picture:hover {
            transform: scale(1.05);
        }

        .upload-btn {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1.5rem;
            background: var(--primary-red);
            color: white;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            background: var(--dark-red);
            box-shadow: 0 3px 10px rgba(231, 76, 60, 0.3);
        }

        /* Document Upload */
        .document-upload {
            border: 2px dashed var(--primary-red);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            background: rgba(231, 76, 60, 0.05);
        }

        .document-upload:hover {
            background: rgba(231, 76, 60, 0.1);
        }

        .document-upload label {
            font-weight: 600;
            color: var(--primary-red);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .document-upload label i {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }

        .document-preview {
            display: none;
            margin-top: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .document-preview img {
            width: 50px;
            height: 50px;
            margin-right: 1rem;
        }

        .document-details {
            text-align: left;
        }

        /* Work Days Section */
        .day-card {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            border-left: 3px solid var(--primary-red);
        }

        .day-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-section {
            animation: fadeIn 0.5s ease forwards;
        }

        .form-section:nth-child(2) { animation-delay: 0.1s; }
        .form-section:nth-child(3) { animation-delay: 0.2s; }
        .form-section:nth-child(4) { animation-delay: 0.3s; }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .application-title {
                font-size: 2rem;
            }
            
            .form-section {
                padding: 1.5rem;
            }
        }
    </style>
@endsection

@section('external-home-content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="application-container">
                    <div class="application-header">
                        <h1 class="application-title text-white">Courier Delivery Application</h1>
                        <p class="application-subtitle">Join our team of professional delivery partners</p>
                    </div>

                    <form method="POST" action="{{ route('courier.apply') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Personal Information Section -->
                        <div class="form-section">
                            <h3 class="form-section-title">Personal Information</h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            id="first_name" name="first_name" placeholder="Enter your first name"
                                            value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            id="last_name" name="last_name" placeholder="Enter your last name"
                                            value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" placeholder="Enter your email address"
                                            value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" placeholder="Enter your phone number"
                                            value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" class="form-control @error('dob') is-invalid @enderror"
                                            id="dob" name="dob" value="{{ old('dob') }}" required>
                                        @error('dob')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="address">Home Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            id="address" name="address" placeholder="Enter your home address"
                                            value="{{ old('address') }}" required>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Information Section -->
                        <div class="form-section">
                            <h3 class="form-section-title">Vehicle Information</h3>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="vehicleType">Vehicle Type</label>
                                        <select class="form-control @error('vehicleType') is-invalid @enderror"
                                            id="vehicleType" name="vehicleType" required>
                                            <option value="">Select your vehicle type</option>
                                            <option value="bike"
                                                {{ old('vehicleType') == 'bike' ? 'selected' : '' }}>Bike
                                            </option>
                                            <option value="car" {{ old('vehicleType') == 'car' ? 'selected' : '' }}>
                                                Car
                                            </option>
                                            <option value="van" {{ old('vehicleType') == 'van' ? 'selected' : '' }}>
                                                Van
                                            </option>
                                            <option value="truck"
                                                {{ old('vehicleType') == 'truck' ? 'selected' : '' }}>Truck
                                            </option>
                                        </select>
                                        @error('vehicleType')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="licenseNumber">Driving License Number</label>
                                        <input type="text"
                                            class="form-control @error('licenseNumber') is-invalid @enderror"
                                            id="licenseNumber" name="licenseNumber"
                                            placeholder="Enter your driving license number"
                                            value="{{ old('licenseNumber') }}" required>
                                        @error('licenseNumber')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="licenseIssueDate">License Issue Date</label>
                                        <input type="date"
                                            class="form-control @error('licenseIssueDate') is-invalid @enderror"
                                            id="licenseIssueDate" name="licenseIssueDate"
                                            value="{{ old('licenseIssueDate') }}" required>
                                        @error('licenseIssueDate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="nationalId">National ID Number</label>
                                        <input type="text"
                                            class="form-control @error('nationalId') is-invalid @enderror"
                                            id="nationalId" name="nationalId"
                                            placeholder="Enter your national ID number"
                                            value="{{ old('nationalId') }}" required>
                                        @error('nationalId')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Details Section -->
                        <div class="form-section">
                            <h3 class="form-section-title">Work Availability</h3>

                            @php
                                $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                            @endphp

                            @foreach ($daysOfWeek as $key => $day)
                                <div class="day-card">
                                    <div class="day-name">{{ $day }}</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="startTime_{{ $loop->index }}">Start Time</label>
                                                <input type="time"
                                                    class="form-control @error('startTime.' . $loop->index) is-invalid @enderror"
                                                    id="startTime_{{ $loop->index }}" name="startTime[]"
                                                    value="{{ old('startTime.' . $loop->index) }}">
                                                @error('startTime.' . $loop->index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="endTime_{{ $loop->index }}">End Time</label>
                                                <input type="time"
                                                    class="form-control @error('endTime.' . $loop->index) is-invalid @enderror"
                                                    id="endTime_{{ $loop->index }}" name="endTime[]"
                                                    value="{{ old('endTime.' . $loop->index) }}">
                                                @error('endTime.' . $loop->index)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mb-4 form-group">
                                <label for="experience">Previous Experience</label>
                                <textarea class="form-control @error('experience') is-invalid @enderror" id="experience" name="experience"
                                    rows="4" placeholder="Describe your previous delivery experience, if any">{{ old('experience') }}</textarea>
                                @error('experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="reference">Reference Name</label>
                                        <input type="text"
                                            class="form-control @error('reference') is-invalid @enderror"
                                            id="reference" name="reference" placeholder="Enter reference name"
                                            value="{{ old('reference') }}">
                                        @error('reference')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4 form-group">
                                        <label for="referenceContact">Reference Contact</label>
                                        <input type="text"
                                            class="form-control @error('referenceContact') is-invalid @enderror"
                                            id="referenceContact" name="referenceContact"
                                            placeholder="Enter reference contact details"
                                            value="{{ old('referenceContact') }}">
                                        @error('referenceContact')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Documents Section -->
                        <div class="form-section">
                            <h3 class="form-section-title">Upload Documents</h3>

                            <div class="profile-picture-wrapper">
                                <img id="profilePicturePreview" class="profile-picture"
                                    src="https://ui-avatars.com/api/?name=John+Doe&background=e74c3c&color=fff&size=200" 
                                    alt="Profile Picture Preview">
                                <label for="profilePicture" class="upload-btn">
                                    <i class="fas fa-camera me-2"></i> Upload Photo
                                </label>
                                <input type="file" class="d-none" id="profilePicture" name="profilePicture"
                                    accept="image/*">
                                @error('profilePicture')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="document-upload">
                                <label for="resume">
                                    <i class="fas fa-file-upload"></i> Upload Resume (PDF or DOC)
                                </label>
                                <input type="file" class="d-none" id="resume" name="resume"
                                    accept=".pdf, .doc, .docx">
                                <div class="document-preview" id="resumePreview">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('uploads/icons8-file-256.png') }}" alt="File Icon">
                                        <div class="document-details">
                                            <p id="fileName" class="mb-1 font-weight-bold"></p>
                                            <p id="fileSize" class="mb-0 text-muted small"></p>
                                        </div>
                                    </div>
                                </div>
                                @error('resume')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-section text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i> Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('external-js')
    <script>
        $(document).ready(function() {
            // Profile picture preview
            $('#profilePicture').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profilePicturePreview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Resume preview
            $('#resume').change(function() {
                const file = this.files[0];
                const preview = $('#resumePreview');
                
                if (file) {
                    const fileName = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                    
                    $('#fileName').text(fileName);
                    $('#fileSize').text(fileSize);
                    preview.fadeIn();
                } else {
                    preview.fadeOut();
                }
            });

            // Animate form sections on scroll
            $(window).scroll(function() {
                $('.form-section').each(function() {
                    const position = $(this).offset().top;
                    const scroll = $(window).scrollTop();
                    const windowHeight = $(window).height();
                    
                    if (scroll + windowHeight > position + 100) {
                        $(this).addClass('animated');
                    }
                });
            });
        });
    </script>
@endsection