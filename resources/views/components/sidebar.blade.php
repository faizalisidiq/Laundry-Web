<div class="sidebar" id="sidebar">
  @if (auth()->user()->isAdmin())
    <h4 class="text-center text-white mb-4 fw-bold">Laundry Admin</h4>
  @elseif (auth()->user()->isKaryawan())
    <h4 class="text-center text-white mb-4 fw-bold">Laundry Karyawan</h4>
  @endif

  <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
    🏠 Dashboard
  </a>

  @if (auth()->user()->isAdmin())
    <a href="{{ route('layanan.index') }}" class="{{ request()->routeIs('layanan.*') ? 'active' : '' }}">
      🧺 Layanan
    </a>
  @endif

  <a href="{{ route('pesanan.index') }}" class="{{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
    📋 Pesanan
  </a>

  <hr class="my-2" style="border-color: rgba(255,255,255,0.2);">

  @if (auth()->user()->isAdmin())
    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
      👥 Kelola User
    </a>
  @endif

  <hr class="my-2" style="border-color: rgba(255,255,255,0.2);">

  <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
      🚪 Logout
    </a>
  </form>

  <!-- Info Role -->
  <div class="px-3 py-2 mt-4">
    <small class="text-white-50">Login sebagai:</small>
    <div class="badge bg-light text-primary w-100 mt-1">
      {{ Auth::user()->role->display_name }}
    </div>
  </div>

  <!-- Bubbles Animation -->
  <div class="bubbles">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
  </div>
</div>

<!-- Hamburger Button (Mobile Only) -->
<button class="hamburger-btn" id="hamburgerBtn" type="button">
  <i class="bi bi-list"></i>
</button>

<!-- Overlay untuk mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
/* ========== SIDEBAR DESKTOP ========== */
.sidebar {
  width: 240px;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  background: linear-gradient(135deg, #F5A83B 30%, #F5C16B 100%);
  color: #fff;
  padding-top: 1rem;
  padding-bottom: 2rem;
  z-index: 1000;
  display: flex;
  flex-direction: column;
  overflow-y: auto;
  transition: transform 0.3s ease;
}

.sidebar a {
  color: #ffffffcc;
  text-decoration: none;
  display: block;
  padding: 12px 20px;
  transition: all 0.3s;
  border-left: 3px solid transparent;
}

.sidebar a:hover {
  background: rgba(255, 255, 255, 0.1);
  color: #fff;
  border-left-color: #fff;
}

.sidebar a.active {
  background: rgba(255, 255, 255, 0.2);
  color: #fff;
  border-left-color: #fff;
  font-weight: 600;
}

/* ========== HAMBURGER BUTTON ========== */
.hamburger-btn {
  display: none;
  position: fixed;
  top: 15px;
  left: 15px;
  z-index: 1100;
  background: #F5A83B;
  border: none;
  border-radius: 8px;
  width: 45px;
  height: 45px;
  color: white;
  font-size: 24px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
  cursor: pointer;
  transition: all 0.3s;
}

.hamburger-btn:hover {
  background: #F5C16B;
  transform: scale(1.05);
}

.hamburger-btn:active {
  transform: scale(0.95);
}

/* ========== OVERLAY ========== */
.sidebar-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.sidebar-overlay.active {
  display: block;
  opacity: 1;
}

/* ========== BUBBLES ANIMATION ========== */
.bubbles {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 240px;
  height: 100%;
  pointer-events: none;
  z-index: 0;
  overflow: hidden;
}

.bubble {
  position: absolute;
  border-radius: 50%;
  background: radial-gradient(circle at 40% 40%, 
    rgba(24, 186, 255, 0.5), 
    rgba(255, 189, 145, 0.3));
  opacity: 0.7;
  animation: floatBubble linear infinite;
  box-shadow: 
    inset 0 10px 20px rgba(255, 255, 255, 0.3),
    0 4px 15px rgba(52, 152, 219, 0.2);
}

.bubble::before {
  content: '';
  position: absolute;
  top: 10%;
  left: 15%;
  width: 40%;
  height: 40%;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.6), transparent);
  border-radius: 50%;
}

@keyframes floatBubble {
  0% {
    transform: translateY(0) rotate(0deg);
    opacity: 0.7;
  }
  50% {
    opacity: 0.9;
  }
  100% {
    transform: translateY(-110vh) rotate(360deg);
    opacity: 0;
  }
}

/* Bubble variations */
.bubble:nth-child(1) {
  width: 40px;
  height: 40px;
  left: 10%;
  bottom: -50px;
  animation-duration: 12s;
  animation-delay: 0s;
}

.bubble:nth-child(2) {
  width: 30px;
  height: 30px;
  left: 30%;
  bottom: -40px;
  animation-duration: 14s;
  animation-delay: 2s;
}

.bubble:nth-child(3) {
  width: 25px;
  height: 25px;
  left: 50%;
  bottom: -35px;
  animation-duration: 10s;
  animation-delay: 4s;
}

.bubble:nth-child(4) {
  width: 35px;
  height: 35px;
  left: 70%;
  bottom: -45px;
  animation-duration: 13s;
  animation-delay: 1s;
}

.bubble:nth-child(5) {
  width: 28px;
  height: 28px;
  left: 85%;
  bottom: -38px;
  animation-duration: 11s;
  animation-delay: 3s;
}

.bubble:nth-child(6) {
  width: 32px;
  height: 32px;
  left: 15%;
  bottom: -42px;
  animation-duration: 15s;
  animation-delay: 0.5s;
}

.bubble:nth-child(7) {
  width: 27px;
  height: 27px;
  left: 40%;
  bottom: -37px;
  animation-duration: 12.5s;
  animation-delay: 2.5s;
}

.bubble:nth-child(8) {
  width: 33px;
  height: 33px;
  left: 60%;
  bottom: -43px;
  animation-duration: 13.5s;
  animation-delay: 1.8s;
}

.bubble:nth-child(9) {
  width: 29px;
  height: 29px;
  left: 80%;
  bottom: -39px;
  animation-duration: 11.5s;
  animation-delay: 3.5s;
}

.bubble:nth-child(10) {
  width: 26px;
  height: 26px;
  left: 25%;
  bottom: -36px;
  animation-duration: 10.5s;
  animation-delay: 4.5s;
}

/* ========== RESPONSIVE MOBILE ========== */
@media (max-width: 768px) {
  /* Hide sidebar by default on mobile */
  .sidebar {
    transform: translateX(-100%);
  }

  /* Show sidebar when active */
  .sidebar.active {
    transform: translateX(0);
  }

  /* Show hamburger button on mobile */
  .hamburger-btn {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  /* Adjust content margin for mobile */
  .content {
    margin-left: 0 !important;
    padding: 15px !important;
  }

  .navbar {
    margin-left: 0 !important;
    padding-left: 60px; /* Space for hamburger button */
  }

  /* Make sidebar full width on small screens */
  .sidebar {
    width: 280px;
  }

  .bubbles {
    width: 280px;
  }

  /* Smaller font on mobile */
  .sidebar h4 {
    font-size: 1.1rem;
  }

  .sidebar a {
    padding: 14px 20px;
    font-size: 0.95rem;
  }
}

@media (max-width: 480px) {
  .sidebar {
    width: 250px;
  }

  .bubbles {
    width: 250px;
  }

  .hamburger-btn {
    width: 40px;
    height: 40px;
    font-size: 20px;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.getElementById('sidebar');
  const hamburgerBtn = document.getElementById('hamburgerBtn');
  const overlay = document.getElementById('sidebarOverlay');

  // Toggle sidebar
  hamburgerBtn.addEventListener('click', function() {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
  });

  // Close sidebar when clicking overlay
  overlay.addEventListener('click', function() {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
  });

  // Close sidebar when clicking a link on mobile
  const sidebarLinks = sidebar.querySelectorAll('a');
  sidebarLinks.forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth <= 768) {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
      }
    });
  });

  // Close sidebar on window resize to desktop
  window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
      sidebar.classList.remove('active');
      overlay.classList.remove('active');
    }
  });
});
</script>