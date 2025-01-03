<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Activity Reviews</title>
   
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
   
   <style>
       :root {
           --primary-color: #7DC0F8;
           --secondary-color: #3b82f6;
           --star-color: #fbbf24;
       }

       body {
           background-color: #f8fafc;
           font-family: 'Inter', sans-serif;
       }

       .hero-section {
           background-color: var(--primary-color);
           padding: 2rem 0;
           margin-bottom: 2rem;
           color: white;
           border-radius: 0 0 1rem 1rem;
       }

       .review-card {
           border: none;
           border-radius: 1rem;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
           transition: transform 0.3s ease;
       }

       .review-card:hover {
           transform: translateY(-5px);
       }

       .star-rating {
           color: var(--star-color);
       }

       .user-avatar {
           width: 48px;
           height: 48px;
           border-radius: 50%;
           object-fit: cover;
       }

       .rating-input {
           display: none;
       }

       .rating-star {
           cursor: pointer;
           font-size: 1.5rem;
           color: #ccc;
       }

       .rating-star:hover,
       .rating-star.active {
           color: var(--star-color);
       }
   </style>
</head>
<body>
   @include('layouts.partial.menu_user')

   <div class="hero-section">
       <div class="container">
           <div class="row align-items-center">
               <div class="col-md-8">
                   <h1 class="mb-2">Activity Reviews</h1>
                   <p class="mb-0">See what others are saying about our volunteer activities</p>
               </div>
               <div class="col-md-4 text-md-end">
                   <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                       <i class="fas fa-plus me-2"></i>Add Review
                   </button>
               </div>
           </div>
       </div>
   </div>

   <div class="container">
       @if(session('success'))
           <div class="alert alert-success alert-dismissible fade show" role="alert">
               {{ session('success') }}
               <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>
       @endif

       <div class="row g-4">
           @forelse($reviews as $review)
               <div class="col-md-6">
                   <div class="card review-card">
                       <div class="card-body">
                           <div class="d-flex align-items-center mb-3">
                               <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=random" 
                                    alt="{{ $review->user->name }}" 
                                    class="user-avatar me-3">
                               <div>
                                   <h6 class="mb-0">{{ $review->user->name }}</h6>
                                   <div class="star-rating">
                                       @for($i = 1; $i <= 5; $i++)
                                           <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-muted' }}"></i>
                                       @endfor
                                   </div>
                               </div>
                               <div class="ms-auto">
                                   <div class="text-muted mb-2">{{ \Carbon\Carbon::parse($review->tanggal)->format('d M Y') }}</div>
                                   @if(auth()->id() == $review->id_user)
                                       <div class="btn-group">
                                           <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $review->id }}">
                                               <i class="fas fa-edit"></i>
                                           </button>
                                           <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                               @csrf
                                               @method('DELETE')
                                               <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                                   <i class="fas fa-trash"></i>
                                               </button>
                                           </form>
                                       </div>
                                   @endif
                               </div>
                           </div>

                           <h5 class="card-title mb-3">{{ $review->kegiatan->nama_kegiatan }}</h5>
                           <p class="card-text text-muted mb-0">{{ $review->komentar }}</p>
                       </div>
                   </div>
               </div>

               <!-- Edit Review Modal -->
               <div class="modal fade" id="editReviewModal{{ $review->id }}" tabindex="-1" aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h5 class="modal-title">Edit Review</h5>
                               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                               @csrf
                               @method('PUT')
                               <div class="modal-body">
                                   <div class="mb-3">
                                       <label class="form-label">Rating</label>
                                       <div class="star-rating-input">
                                           @for($i = 1; $i <= 5; $i++)
                                               <input type="radio" name="rating" value="{{ $i }}" class="rating-input" id="editStar{{ $review->id }}{{ $i }}" {{ $review->rating == $i ? 'checked' : '' }} required>
                                               <label for="editStar{{ $review->id }}{{ $i }}" class="rating-star {{ $i <= $review->rating ? 'active' : '' }}">
                                                   <i class="fas fa-star"></i>
                                               </label>
                                           @endfor
                                       </div>
                                   </div>

                                   <div class="mb-3">
                                       <label class="form-label">Your Review</label>
                                       <textarea name="komentar" class="form-control" rows="4" required>{{ $review->komentar }}</textarea>
                                   </div>
                               </div>
                               <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                   <button type="submit" class="btn btn-primary">Update Review</button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           @empty
               <div class="col-12 text-center py-5">
                   <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                   <h4>No Reviews Yet</h4>
                   <p class="text-muted">Be the first to review an activity!</p>
               </div>
           @endforelse
       </div>
   </div>

   <!-- Add Review Modal -->
   <div class="modal fade" id="addReviewModal" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">Add Review</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <form action="{{ route('reviews.store') }}" method="POST">
                   @csrf
                   <div class="modal-body">
                       <div class="mb-3">
                           <label class="form-label">Select Activity</label>
                           <select name="id_kegiatan" class="form-select" required>
                               <option value="">Choose an activity...</option>
                               @foreach($activities as $activity)
                                   <option value="{{ $activity->id }}">{{ $activity->nama_kegiatan }}</option>
                               @endforeach
                           </select>
                       </div>

                       <div class="mb-3">
                           <label class="form-label">Rating</label>
                           <div class="star-rating-input">
                               @for($i = 1; $i <= 5; $i++)
                                   <input type="radio" name="rating" value="{{ $i }}" class="rating-input" id="star{{ $i }}" required>
                                   <label for="star{{ $i }}" class="rating-star">
                                       <i class="fas fa-star"></i>
                                   </label>
                               @endfor
                           </div>
                       </div>

                       <div class="mb-3">
                           <label class="form-label">Your Review</label>
                           <textarea name="komentar" class="form-control" rows="4" required></textarea>
                       </div>

                       <input type="hidden" name="id_user" value="{{ auth()->id() }}">
                       <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                       <button type="submit" class="btn btn-primary">Submit Review</button>
                   </div>
               </form>
           </div>
       </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script>
       // Star rating functionality for both add and edit modals
       document.querySelectorAll('.rating-star').forEach(star => {
           star.addEventListener('click', function() {
               const rating = this.previousElementSibling.value;
               const modal = this.closest('.modal');
               const stars = modal.querySelectorAll('.rating-star');
               stars.forEach(s => s.classList.remove('active'));
               stars.forEach((s, index) => {
                   if (index < rating) s.classList.add('active');
               });
           });
       });
   </script>
</body>
</html>