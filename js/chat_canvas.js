document.addEventListener("DOMContentLoaded", () => {
  // accessing DOM
  const sellerChatBtns = document.querySelectorAll(".chat-seller");

  const canvasTitle = document.getElementById("chat-title");
  const canvasHeader = document.getElementById("chat-header");
  const canvasBody = document.getElementById("chat-body");
  const canvasFooter = document.getElementById("chat-footer");

  const chatForm = canvasFooter.querySelector(".typing-area");
  const chatInput = canvasFooter.querySelector(".chat-input");
  const sendBtn = canvasFooter.querySelector(".send-btn");

  const fetchMessages = () => {
    const sellerId = canvasBody.getAttribute("data-seller-id");
    const userId = canvasBody.getAttribute("data-user-id");

    const isUserAtBottom =
      canvasBody.scrollTop + canvasBody.clientHeight >= canvasBody.scrollHeight;

    $.ajax({
      url: "./extension/fetch_message.php",
      type: "POST",
      data: {
        sellerId: sellerId,
        userId: userId,
      },
      success: function (response) {
        canvasBody.innerHTML = response;

        // Check if the user was at the bottom before fetching new messages
        if (isUserAtBottom) {
          // Scroll to the bottom only if the user was already at the bottom
          canvasBody.scrollTop = canvasBody.scrollHeight;
        } else {
          // If the user was not at the bottom, maintain their scroll position
          canvasBody.scrollTop +=
            canvasBody.scrollHeight - previousScrollHeight;
        }

        console.log(`line 32 chatcanvas.js`);
      },
      error: function (error) {
        console.error("Error fetching messages:", error);
      },
    });
  };

  const sendMessages = () => {
    console.log("Im executed 41");
    const message = chatInput.value;

    const sellerId = canvasBody.getAttribute("data-seller-id");
    const userId = canvasBody.getAttribute("data-user-id");
    const sellerData = JSON.parse(canvasBody.getAttribute("data-seller-data"));

    // INSERT TO DB
    $.ajax({
      url: "./extension/insert_message.php",
      type: "POST",
      data: {
        message: message,
        sellerId: sellerId,
        userId: userId,
      },
      success: function (response) {
        console.log("Message sent successfully:", response);

        chatInput.value = "";
        fetchMessages();
      },
      error: function (error) {
        console.error("Error sending message:", error);
      },
    });
  };

  let messageInterval;

  // HANDLE CHAT
  sellerChatBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      // Extract data from btn
      const sellerId = btn.getAttribute("data-seller-id");
      const userId = btn.getAttribute("data-user-id");
      const sellerData = JSON.parse(btn.getAttribute("data-seller-data"));

      canvasTitle.textContent = sellerData.fullname;
      canvasBody.setAttribute("data-seller-id", sellerId);
      canvasBody.setAttribute("data-user-id", userId);
      canvasBody.setAttribute("data-seller-data", JSON.stringify(sellerData));

      // FETCH MESSAGES FROM DB
      fetchMessages();

      if (messageInterval) {
        clearInterval(messageInterval);
      }
      messageInterval = setInterval(fetchMessages, 2000);
    });
  });

  // HANDLE SEND
  sendBtn.addEventListener("click", () => {
    console.log("im executed 95");
    sendMessages();
  });
  chatForm.addEventListener("submit", (event) => {
    event.preventDefault();

    sendMessages();
  });
});
