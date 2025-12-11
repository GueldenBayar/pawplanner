document.addEventListener("DOMContentLoaded", () => {
    const likeBtn = document.getElementById("like-btn");
    const nopeBtn = document.getElementById("nope-btn");

    function swipe(card, direction) {
        card.style.transform =
            `translateX(${direction === 'right' ? 500 : -500}px) rotate(30deg)`;
        card.style.opacity = 0;

        const dogId = card.dataset.dogId;
        const userId = card.dataset.userId;

        setTimeout(() => {
            card.remove();
            sendLike(direction === "right", dogId, userId);
        }, 250);
    }

    function sendLike(like, dogId, userId) {
        fetch("like.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `like=${like ? 1 : 0}&dog_id=${dogId}&user_id=${userId}`
        });
    }

    likeBtn.addEventListener("click", () => {
        const card = document.querySelector(".dog-card:first-child");
        if (card) swipe(card, "right");
    });

    nopeBtn.addEventListener("click", () => {
        const card = document.querySelector(".dog-card:first-child");
        if (card) swipe(card, "left");
    });

})