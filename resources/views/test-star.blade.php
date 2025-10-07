<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Star Rating</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ccc; }
        .debug { background: #f0f0f0; padding: 10px; margin: 10px 0; font-family: monospace; }
    </style>
</head>
<body>
    <h1>Test Star Rating Component</h1>
    
    <div class="test-section">
        <h3>Interactive Star Rating (Default)</h3>
        <x-star-rating :rating="0" :interactive="true" size="lg" />
        <div class="debug">
            <p>Click on stars above to test interactivity</p>
            <p>Check browser console for debug messages</p>
        </div>
    </div>
    
    <div class="test-section">
        <h3>Display Star Rating (3 stars)</h3>
        <x-star-rating :rating="3" :interactive="false" size="lg" />
    </div>
    
    <div class="test-section">
        <h3>Interactive Star Rating (Small)</h3>
        <x-star-rating :rating="0" :interactive="true" size="sm" />
    </div>
    
    <div class="debug">
        <h4>Debug Info:</h4>
        <p>Page loaded at: <span id="load-time"></span></p>
        <p>Stars found: <span id="star-count"></span></p>
    </div>
    
    <script>
        document.getElementById('load-time').textContent = new Date().toLocaleTimeString();
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, checking for star ratings...');
            const stars = document.querySelectorAll('.star');
            document.getElementById('star-count').textContent = stars.length;
            
            console.log('Found stars:', stars.length);
            
            stars.forEach((star, index) => {
                console.log('Star', index, 'data-value:', star.dataset.value);
            });
        });
    </script>
</body>
</html>