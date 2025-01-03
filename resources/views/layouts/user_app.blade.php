@extends('layouts.user')

@section('content')
    <!-- Banner Section -->
    <div class="row g-0">
        <div class="col-md-6 text-white d-flex align-items-center justify-content-start ps-4" 
             style="height: 400px; 
                    background: linear-gradient(rgb(125,192,248,0.5), rgb(125,192,248,0.5)), url('{{ asset('img/banner.jpg') }}');
                    background-size: cover;">
            <h2 class="display-4 fw-bold">DO SOMETHING GREAT<br>TO HELP OTHERS</h2>
        </div>
        <div class="col-md-6" 
             style="background-image: url('{{ asset('img/banner2.jpg') }}'); 
                    background-size: cover; 
                    height: 400px;">
        </div>
    </div>
    
    <div class="container text-center py-5">
        <div class="row">
            <div class="col-md-4">
                <p class="display-4" style="color: #7DC0F8">{{ number_format($counts['volunteers']) }}</p>
                <p class="text-muted">Volunteers</p>
            </div>
            <div class="col-md-4">
                <p class="display-4" style="color: #7DC0F8"">{{ number_format($counts['campaigns']) }}</p>
                <p class="text-muted">Campaigns</p>
            </div>
            <div class="col-md-4">
                <p class="display-4" style="color: #7DC0F8"">{{ number_format($counts['organizations']) }}</p>
                <p class="text-muted">Organizations</p>
            </div>
        </div>
        <a class="btn btn-lg mt-4" style="background-color: #8ecbf7; color: white" href="{{ route('kegiatan_volunteers.list') }}">Join Us as a Volunteer</a>
    </div>

    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{ asset('img/group.jpg') }}" alt="Group" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold">Small Changes<br>do change the future better.</h3>
                <p class="text-muted mt-3"><em>Start <span style="color: #7DC0F8" class="fw-bold">with KIND</span></em></p>
                <p class="mt-3">Every small action has the power to create a brighter future. Join us in making meaningful change, no matter how small.</p>
            </div>
        </div>
    </div>


    <div class="container text-center py-5">
        <h3 class="fw-bold">Categories</h3>
        <div class="row row-cols-2 row-cols-md-6 g-4 mt-4">
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center category-circle">
                    <span class="category-emoji">📚</span>
                </div>
                <p class="mt-2 text-muted category-text">Education</p>
            </div>
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center category-circle">
                    <span class="category-emoji">❤️</span>
                </div>
                <p class="mt-2 text-muted category-text">Health</p>
            </div>
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center category-circle">
                    <span class="category-emoji">🌱</span>
                </div>
                <p class="mt-2 text-muted category-text">Environment</p>
            </div>
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center category-circle">
                    <span class="category-emoji">🤝</span>
                </div>
                <p class="mt-2 text-muted category-text">Social Service</p>
            </div>
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center category-circle">
                    <span class="category-emoji">🏠</span>
                </div>
                <p class="mt-2 text-muted category-text">Community</p>
            </div>
            <div class="col">
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center category-circle">
                    <span class="category-emoji">🐾</span>
                </div>
                <p class="mt-2 text-muted category-text">Animal</p>
            </div>
        </div>
    </div>

    <div style="background-color: #8ecbf7" class="text-white py-5">
        <div class="container text-center">
            <h3 class="fw-bold">Trash Talk:<br> Let's Clean Our Community!</h3>
            <p class="mt-2">Campaign period 9 Aug - 11 Aug</p>
        </div>
    </div>


    <div class="container py-5">
        <h3 class="fw-bold text-center mb-4">Explore Projects</h3>
        <div class="position-relative">
            <div id="projectControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($kegiatanVolunteers->chunk(3) as $index => $chunk)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                @foreach($chunk as $kegiatan)
                                    <div class="col-md-4">
                                        <div class="card border-0 h-100">
                                            <img src="{{ asset($kegiatan->banner) }}" alt="{{ $kegiatan->nama_kegiatan }}" 
                                                 class="d-block w-100 rounded shadow">
                                            <div class="card-body px-0">
                                                <h4 class="fw-bold mt-3">{{ $kegiatan->nama_kegiatan }}</h4>
                                                <p class="text-muted">{{ $kegiatan->lembaga->nama }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#projectControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#projectControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <h3 class="fw-bold text-center mb-4">Partnered Organizations</h3>
        <div class="position-relative">
            <div id="organizationControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($lembagas->chunk(3) as $index => $chunk)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row g-4">
                                @foreach($chunk as $lembaga)
                                    <div class="col-md-4">
                                        <div class="card border-0 h-100">
                                            <div class="image-container rounded shadow">
                                                <img src="{{ asset($lembaga->logo) }}" 
                                                     alt="{{ $lembaga->nama }}" 
                                                     class="d-block">
                                            </div>
                                            <div class="card-body px-0">
                                                <h4 class="fw-bold mt-3">{{ $lembaga->nama }}</h4>
                                                <p class="text-muted">{{ $lembaga->deskripsi }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#organizationControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#organizationControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

@endsection 

<style>
    .category-circle {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .category-circle:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        background-color: #f8f9fa !important;
    }

    .category-emoji {
        font-size: 2.5rem;
        transition: all 0.3s ease;
    }

    .category-circle:hover .category-emoji {
        transform: scale(1.1);
    }

    .category-text {
        transition: all 0.3s ease;
    }

    .category-circle:hover + .category-text {
        color: #8ecbf7!important;
    }


    .card {
        position: relative;
        width: 100%;
    }

    .card .image-container {
        position: relative;
        width: 100%;
        padding-top: 100%; 
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .card .image-container img {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 80%; 
        max-height: 80%; 
        width: auto;
        height: auto;
        object-fit: contain; 
    }

</style> 

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script> 