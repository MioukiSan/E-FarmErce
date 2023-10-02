document.addEventListener("DOMContentLoaded", () => {
  const chatBtn = document.querySelector(".chat-dropdown-btn");
  const chatDropdownList = document.querySelector(".chat-dropdown-list");
  const userId = chatBtn.getAttribute("data-user-id");
  const canvasBody = document.getElementById("chat-body");

  const fetchMessages = (incomingId, outgoingId) => {
    const isUserAtBottom =
      canvasBody.scrollTop + canvasBody.clientHeight >= canvasBody.scrollHeight;
    console.log("fetch with parameters");
    $.ajax({
      url: "./extension/fetch_message.php",
      type: "POST",
      data: {
        sellerId: incomingId,
        userId: outgoingId != null ? outgoingId : userId,
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
      },
      error: function (error) {
        console.error("Error fetching messages:", error);
      },
    });
  };

  let messageInterval;

  // Function to open the chat canvas
  const openChatCanvas = (fullname, incomingId) => {
    const chatCanvas = document.getElementById("offcanvasScrolling");
    const chatTitle = document.getElementById("chat-title");
    // You can customize the title based on the selected user
    chatTitle.textContent = fullname;

    const chat = new bootstrap.Offcanvas(chatCanvas);
    chat.show();
    fetchMessages(incomingId);

    if (messageInterval) {
      clearInterval(messageInterval);
    }
    messageInterval = setInterval(() => {
      fetchMessages(incomingId, userId);
    }, 2000);
  };

  //   FETCH CHAT LIST
  const fetchUsers = () => {
    console.log("im 42");
    $.ajax({
      url: "./extension/fetch_users.php",
      type: "POST",
      data: {
        userId: userId,
      },
      success: function (response) {
        const userList = JSON.parse(response);
        const titleRow = document.createElement("div");
        titleRow.classList.add(
          "row",
          "border-bottom",
          "py-1",
          "chat-dropdown-title"
        );
        titleRow.innerHTML = `
        <div class="col-md-12 d-flex align-items-center text-center">
                
               <p class="title-chat w-100 mb-0 fs-5">MESSAGES</p>
                </div>
        `;
        chatDropdownList.appendChild(titleRow);
        userList.forEach((user) => {
          const row = document.createElement("div");
          row.classList.add("row", "border-bottom", "py-1", "chat-indiv-user");
          row.setAttribute("data-user-id", user.user_id);
          row.setAttribute("data-fullname", user.fullname);
          row.innerHTML = `
                <div class="col-md-12 mx-3 d-flex align-items-center py-1">
                
                <button class="btn p-0 m-0 d-flex align-items-center" ><ion-icon class='me-2' size="large" name="person-circle-outline"></ion-icon><p class="mb-0">${user.fullname}</p></button>
                </div>
          
          
            `;
          chatDropdownList.appendChild(row);
          row.addEventListener("click", (e) => {
            e.stopPropagation();
            console.log(user.fullname);
            canvasBody.setAttribute("data-seller-id", user.user_id);
            canvasBody.setAttribute("data-user-id", userId);
            canvasBody.setAttribute(
              "data-seller-data",
              JSON.stringify({
                user: user.fullname,
              })
            );
            openChatCanvas(user.fullname, user.user_id);
          });
        });

        console.log(`line 79 chaticon.js`);
      },
      error: function (error) {
        console.error("Error fetching messages:", error);
      },
    });
  };

  //   HANDLE CHAT
  chatBtn.addEventListener("click", () => {
    chatDropdownList.innerHTML = "";
    fetchUsers();
  });
});
