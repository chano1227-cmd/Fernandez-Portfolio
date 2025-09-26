const userButton = document.getElementById('user-button');

userButton.addEventListener('click', function(event) {
    event.preventDefault();
   
    window.location.href = 'user.html'; 
});



document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector('.booking form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const occasion = document.getElementById('occasion').value;
            const date = document.getElementById('date').value;
            const message = document.getElementById('message').value;

            // Basic validation 
            if (!name || !email || !occasion || !date) {
                alert("Please fill in all required fields.");
                return;
            }

            //  confirmation message
            const confirmationMessage = `
                Thank you for your booking, ${name}!
                \nOccasion: ${occasion}
                \nDate: ${date}
                \nSpecial Requests: ${message ? message : 'None'}
                \nWe will contact you at ${email} for further details.
            `;

            alert(confirmationMessage);
            form.reset();
        });
    });