<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Page Messages</title>
</head>
<body>
    <h1>Select a Facebook Page</h1>
    <select id="pages-dropdown">
		<option>Select page</option>
	</select>
    <ul id="messages-list"></ul>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("/facebook/pages")
                .then(response => response.json())
                .then(data => {
                    let dropdown = document.getElementById("pages-dropdown");
                    data.data.forEach(page => {
                        let option = document.createElement("option");
                        option.value = page.id;
                        option.dataset.token = page.access_token;
                        option.textContent = page.name;
                        dropdown.appendChild(option);
                    });

                    dropdown.addEventListener("change", function() {
                        let pageId = this.value;
                        let accessToken = this.options[this.selectedIndex].dataset.token;
                        fetch(`/facebook/messages/${pageId}?access_token=${accessToken}`)
                            .then(response => response.json())
                            .then(data => {
                                let messagesList = document.getElementById("messages-list");
                                messagesList.innerHTML = "";
                                data.data.forEach(conversation => {
                                    let li = document.createElement("li");
                                    li.innerHTML = `<a href="/facebook/conversation/${conversation.id}?access_token=${accessToken}">${conversation.id}</a>`;
                                    messagesList.appendChild(li);
                                });
                            });
                    });
                })
                .catch(error => console.error("Error fetching pages:", error));
        });
    </script>
</body>
</html>
