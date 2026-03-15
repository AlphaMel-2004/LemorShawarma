@props(['testimonial'])

<div class="testimonial-card">
    <!-- Quote Icon -->
    <div class="quote-icon">
        <i class="bi bi-quote"></i>
    </div>
    
    <!-- Content -->
    <div class="testimonial-content">
        <p class="testimonial-text">{{ $testimonial['content'] }}</p>
    </div>
    
    <!-- Rating -->
    <div class="testimonial-rating">
        @for($i = 0; $i < $testimonial['rating']; $i++)
            <i class="bi bi-star-fill"></i>
        @endfor
    </div>
    
    <!-- Author -->
    <div class="testimonial-author">
        <div class="author-avatar">
            <span class="avatar-initials" aria-label="{{ $testimonial['name'] }} initials">
                {{ $testimonial['initials'] ?? 'GU' }}
            </span>
        </div>
        <div class="author-info">
            <h4 class="author-name">{{ $testimonial['name'] }}</h4>
            <span class="author-role">{{ $testimonial['role'] }}</span>
        </div>
    </div>
</div>
