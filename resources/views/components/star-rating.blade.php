@props(['rating' => 0, 'interactive' => false, 'size' => 'md'])

@php
    $sizeMap = [
        'sm' => '20px',
        'md' => '24px', 
        'lg' => '32px',
        'xl' => '40px'
    ];
    $starSize = $sizeMap[$size] ?? '24px';
@endphp

<div class="star-rating" style="display: inline-flex; gap: 8px; align-items: center; margin: 10px 0;">
    @for ($i = 1; $i <= 5; $i++)
        <span class="star" data-value="{{ $i }}" style="cursor: {{ $interactive ? 'pointer' : 'default' }}; padding: 4px; border-radius: 4px; transition: all 0.2s ease; display: inline-block;">
            <svg width="{{ $starSize }}" height="{{ $starSize }}" 
                 viewBox="0 0 24 24" 
                 fill="{{ $i <= $rating ? '#f97316' : 'none' }}" 
                 stroke="#f97316" 
                 stroke-width="2"
                 class="star-svg">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
        </span>
    @endfor
</div>

@if($interactive)
    <input type="hidden" name="rating_value" value="{{ $rating }}">
@endif

@if($interactive)
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Star rating script loaded');
    
    const starRatings = document.querySelectorAll('.star-rating');
    console.log('Found star ratings:', starRatings.length);
    
    starRatings.forEach((rating, ratingIndex) => {
        const stars = rating.querySelectorAll('.star');
        const hiddenInput = rating.querySelector('input[name="rating_value"]');
        
        console.log('Rating', ratingIndex, 'has', stars.length, 'stars and hidden input:', !!hiddenInput);
        
        if (!hiddenInput) return;
        
        stars.forEach((star, index) => {
            star.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const value = parseInt(this.dataset.value);
                console.log('Star clicked! Value:', value);
                
                hiddenInput.value = value;
                
                // Update all stars
                stars.forEach((s, i) => {
                    const svg = s.querySelector('.star-svg');
                    if (i + 1 <= value) {
                        svg.setAttribute('fill', '#f97316');
                        svg.style.fill = '#f97316';
                    } else {
                        svg.setAttribute('fill', 'none');
                        svg.style.fill = 'none';
                    }
                });
                
                console.log('Updated rating to:', value);
            });
            
            star.addEventListener('mouseenter', function() {
                const value = parseInt(this.dataset.value);
                stars.forEach((s, i) => {
                    const svg = s.querySelector('.star-svg');
                    if (i + 1 <= value) {
                        svg.style.fill = '#ea580c';
                    } else {
                        svg.style.fill = '#ea580c';
                    }
                });
            });
        });
        
        rating.addEventListener('mouseleave', function() {
            const currentRating = parseInt(hiddenInput.value) || 0;
            stars.forEach((s, i) => {
                const svg = s.querySelector('.star-svg');
                if (i + 1 <= currentRating) {
                    svg.style.fill = '#f97316';
                } else {
                    svg.style.fill = 'none';
                }
            });
        });
    });
});
</script>
@endif