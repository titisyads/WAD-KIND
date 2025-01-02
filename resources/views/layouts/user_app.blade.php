@extends('layouts.user')

@section('content')
    <!-- Banner Section -->
    <div class="row g-0">
        <div class="col-md-6 text-white d-flex align-items-center justify-content-start ps-4" 
             style="height: 400px; 
                    background: linear-gradient(rgba(13, 110, 253, 0.5), rgba(13, 110, 253, 0.5)), url('{{ asset('img/banner.jpg') }}');
                    background-size: cover;">
            <h2 class="display-4 fw-bold">DO SOMETHING GREAT<br>TO HELP OTHERS</h2>
        </div>
        <div class="col-md-6" 
             style="background-image: url('{{ asset('img/banner2.jpg') }}'); 
                    background-size: cover; 
                    height: 400px;">
        </div>
    </div>

    <!-- Counters Section -->
    <div class="container text-center py-5">
        <div class="row">
            <div class="col-md-4">
                <p class="display-4 text-primary">{{ number_format($counts['volunteers']) }}</p>
                <p class="text-muted">Volunteers</p>
            </div>
            <div class="col-md-4">
                <p class="display-4 text-primary">{{ number_format($counts['campaigns']) }}</p>
                <p class="text-muted">Campaigns</p>
            </div>
            <div class="col-md-4">
                <p class="display-4 text-primary">{{ number_format($counts['organizations']) }}</p>
                <p class="text-muted">Organizations</p>
            </div>
        </div>
        <a class="btn btn-primary btn-lg mt-4">Join Us as a Volunteer</a>
    </div>

    <!-- Rest of the dashboard content... -->
    
    <!-- Small Changes Section -->
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{ asset('img/group.jpg') }}" alt="Group" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold">Small Changes<br>do change the future better.</h3>
                <p class="text-muted mt-3"><em>Start <span class="text-primary fw-bold">with KIND</span></em></p>
                <p class="mt-3">Every small action has the power to create a brighter future. Join us in making meaningful change, no matter how small.</p>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="container text-center py-5">
        <h3 class="fw-bold">Categories</h3>
        <div class="row row-cols-2 row-cols-md-6 g-4 mt-4">
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto;">
                    <span style="font-size: 2.5rem;">📚</span>
                </div>
                <p class="mt-2 text-muted">Education</p>
            </div>
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto;">
                    <span style="font-size: 2.5rem;">❤️</span>
                </div>
                <p class="mt-2 text-muted">Health</p>
            </div>
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto;">
                    <span style="font-size: 2.5rem;">🌱</span>
                </div>
                <p class="mt-2 text-muted">Environment</p>
            </div>
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto;">
                    <span style="font-size: 2.5rem;">🤝</span>
                </div>
                <p class="mt-2 text-muted">Social Service</p>
            </div>
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto;">
                    <span style="font-size: 2.5rem;">🏠</span>
                </div>
                <p class="mt-2 text-muted">Community</p>
            </div>
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; margin: 0 auto;">
                    <span style="font-size: 2.5rem;">🐾</span>
                </div>
                <p class="mt-2 text-muted">Animal</p>
            </div>
        </div>
    </div>

    <!-- Trash Talk Section -->
    <div class="bg-primary text-white py-5">
        <div class="container text-center">
            <h3 class="fw-bold">Trash Talk:<br> Let's Clean Our Community!</h3>
            <p class="mt-2">Campaign period 9 Aug - 11 Aug</p>
        </div>
    </div>

    <!-- Explore Projects Section -->
    <div class="container py-5">
        <h3 class="fw-bold text-center mb-4">Explore Projects</h3>
        <div class="row g-4">
            <div class="col-md-4">
                <img src="{{ asset('img/project-image1.jpg') }}" alt="Project" class="img-fluid rounded shadow">
                <h4 class="fw-bold mt-3">1000 Trees for Bandung</h4>
                <p class="text-muted">Bandung Karya</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/project-image2.jpg') }}" alt="Project" class="img-fluid rounded shadow">
                <h4 class="fw-bold mt-3">No Hunger</h4>
                <p class="text-muted">Anti Kelaparan INA</p>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('img/project-image3.jpg') }}" alt="Project" class="img-fluid rounded shadow">
                <h4 class="fw-bold mt-3">Clean Up River Hero</h4>
                <p class="text-muted">Hero Sungai Bandung</p>
            </div>
        </div>
    </div>

@endsection 