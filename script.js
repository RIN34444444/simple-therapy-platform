document.addEventListener('DOMContentLoaded', function () {
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    
    const stressLevelInput = document.getElementById('stress_level');
    const sleepQualityInput = document.getElementById('sleep_quality');
    const stressValueDisplay = document.getElementById('stress_value');
    const sleepValueDisplay = document.getElementById('sleep_value');

    stressLevelInput.addEventListener('input', function() {
        stressValueDisplay.textContent = stressLevelInput.value;
    });

    sleepQualityInput.addEventListener('input', function() {
        sleepValueDisplay.textContent = sleepQualityInput.value;
    });

});
