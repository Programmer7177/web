@props(['rating' => 0, 'interactive' => false, 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'w-4 h-4',
        'md' => 'w-6 h-6',
        'lg' => 'w-8 h-8',
        'xl' => 'w-10 h-10'
    ];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div class="star-rating {{ $interactive ? 'interactive' : '' }}" data-rating="{{ $rating }}">
    @for ($i = 1; $i <= 5; $i++)
        <span class="star {{ $interactive ? 'clickable' : '' }}" data-value="{{ $i }}">
            <svg class="{{ $sizeClass }} {{ $i <= $rating ? 'filled' : 'outlined' }}" 
                 viewBox="0 0 24 24" 
                 fill="{{ $i <= $rating ? 'currentColor' : 'none' }}" 
                 stroke="currentColor" 
                 stroke-width="2">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
        </span>
    @endfor
</div>

@if($interactive)
    <input type="hidden" name="rating_value" value="{{ $rating }}">
@endif

<style>
.star-rating {
    display: inline-flex;
    gap: 2px;
    align-items: center;
}

.star-rating .star {
    display: inline-block;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.star-rating .star:hover {
    transform: scale(1.1);
}

.star-rating .star svg.filled {
    color: #f97316; /* Orange color for filled stars */
}

.star-rating .star svg.outlined {
    color: #f97316; /* Orange color for outlined stars */
    fill: none;
}

.star-rating.interactive .star {
    cursor: pointer;
}

.star-rating .star svg {
    transition: all 0.2s ease;
}

.star-rating .star:hover svg {
    color: #ea580c; /* Darker orange on hover */
}
</style>

@if($interactive)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const starRating = document.querySelector('.star-rating.interactive');
    if (!starRating) return;
    
    const stars = starRating.querySelectorAll('.star');
    const hiddenInput = starRating.querySelector('input[name="rating_value"]');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            hiddenInput.value = value;
            
            // Update visual state
            stars.forEach((s, i) => {
                const svg = s.querySelector('svg');
                if (i < value) {
                    svg.classList.remove('outlined');
                    svg.classList.add('filled');
                    svg.setAttribute('fill', 'currentColor');
                } else {
                    svg.classList.remove('filled');
                    svg.classList.add('outlined');
                    svg.setAttribute('fill', 'none');
                }
            });
        });
        
        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.dataset.value);
            stars.forEach((s, i) => {
                const svg = s.querySelector('svg');
                if (i < value) {
                    svg.style.color = '#ea580c';
                } else {
                    svg.style.color = '#d1d5db';
                }
            });
        });
    });
    
    starRating.addEventListener('mouseleave', function() {
        const currentRating = parseInt(hiddenInput.value) || 0;
        stars.forEach((s, i) => {
            const svg = s.querySelector('svg');
            if (i < currentRating) {
                svg.style.color = '#f97316';
            } else {
                svg.style.color = '#f97316';
            }
        });
    });
});
</script>
@endif