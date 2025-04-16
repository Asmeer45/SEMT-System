<!-- ! Main nav -->
<nav class="main-nav--bg">
  <div class="container main-nav">
    <div class="main-nav-start">
      <h1 style="font-family: Arial, sans-serif">SEMT System</h1>
    </div>
    <div class="main-nav-end">

      <button class="theme-switcher gray-circle-btn" type="button" title="Switch theme">
        <span class="sr-only">Switch theme</span>
        <i class="sun-icon" data-feather="sun" aria-hidden="true"></i>
        <i class="moon-icon" data-feather="moon" aria-hidden="true"></i>
      </button>
     
      <div class="nav-user-wrapper">
        <button href="##" class="nav-user-btn dropdown-btn" title="My profile" type="button">
          <span class="sr-only">My profile</span>
          <span class="nav-user-img">
            <picture>
              <source srcset="./img/avatar/avatar-illustrated-02.webp" type="image/webp">
              <img src="./img/avatar/avatar-illustrated-02.png" alt="User name">
            </picture>
          </span>
        </button>
        <ul class="users-item-dropdown nav-user-dropdown dropdown">
          <li><a class="danger logout-btn" href="javascript:void(0);">
              <i data-feather="log-out" aria-hidden="true"></i>
              <span>Log out</span>
            </a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- JavaScript to handle logout functionality -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const logoutBtn = document.querySelector(".logout-btn");

    logoutBtn.addEventListener("click", () => {
      // Redirect to the login page after logout
      window.location.href = "../Login.php"; // Redirect to login.php after logout

      // Alternatively, use an API call for logout if needed
      /*
      fetch('/api/logout', {
        method: 'POST',
        credentials: 'include'
      }).then(response => {
        if (response.ok) {
          window.location.href = "login.php"; // Redirect to login.php after logout
        } else {
          console.error("Logout failed");
        }
      });
      */
    });
  });


    // Browser detection
    function detectBrowser() {
        var userAgent = navigator.userAgent;

        // Check for specific browsers and hide content
        if (userAgent.indexOf("Chrome") > -1) {
            console.log("Chrome detected. Displaying content.");
            return; // Chrome, do nothing
        } else if (userAgent.indexOf("Firefox") > -1) {
            console.log("Firefox detected. Displaying content.");
            return; // Firefox, do nothing
        } else if (userAgent.indexOf("Safari") > -1 && userAgent.indexOf("Chrome") === -1) {
            console.log("Safari detected. Hiding content.");
            document.getElementById('content').classList.add('hidden'); // Hide content for Safari
        } else if (userAgent.indexOf("MSIE") > -1 || userAgent.indexOf("Trident") > -1) {
            console.log("Internet Explorer detected. Hiding content.");
            document.getElementById('content').classList.add('hidden'); // Hide content for IE
        } else if (userAgent.indexOf("Edge") > -1) {
            console.log("Edge detected. Hiding content.");
            document.getElementById('content').classList.add('hidden'); // Hide content for Edge
        } else {
            console.log("Unknown browser. Hiding content.");
            document.getElementById('content').classList.add('hidden'); // Hide content for any other browser
        }
    }

    // Call the browser detection function on page load
    window.onload = detectBrowser;

</script>
