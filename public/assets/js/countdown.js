document.addEventListener('DOMContentLoaded', function() {
    const endTimeString = document.getElementById('cd-enddate').textContent.trim();

    const targetDate = new Date(endTimeString).getTime();

    const daysEl = document.getElementById('cd-days');
    const hoursEl = document.getElementById('cd-hours');
    const minutesEl = document.getElementById('cd-minutes');
    const secondsEl = document.getElementById('cd-seconds');
    const badgeEl = document.querySelector('.countdown-badge'); 

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = targetDate - now;
        const formatTime = (value) => String(value).padStart(2, '0');
        if (distance < 0) {
            
            clearInterval(countdownInterval); 
            
            daysEl.textContent = formatTime(0);
            hoursEl.textContent = formatTime(0);
            minutesEl.textContent = formatTime(0);
            secondsEl.textContent = formatTime(0);

            badgeEl.textContent = "Telah Berakhir";
            badgeEl.classList.remove('countdown-badge');
            badgeEl.classList.add('countdown-badge-ended'); 

            console.log("Countdown Selesai.");
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        daysEl.textContent = formatTime(days);
        hoursEl.textContent = formatTime(hours);
        minutesEl.textContent = formatTime(minutes);
        secondsEl.textContent = formatTime(seconds);
    }
    
    const countdownInterval = setInterval(updateCountdown, 1000);    
    updateCountdown(); 
});