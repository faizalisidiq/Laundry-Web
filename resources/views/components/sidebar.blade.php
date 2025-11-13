<div class="sidebar">
  <h4 class="text-center text-white mb-4 fw-bold">🧺 Laundry System</h4>

<!-- Sidebar -->
<div class="sidebar">
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

    <!-- @if (auth()->user()->isAdmin())
        <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
        🔐 Kelola Role
        </a>
    @endif -->

  <hr class="my-2" style="border-color: rgba(255,255,255,0.2);">

  <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
      🚪 Logout
    </a>

    
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
  </form>
</div>



  <!-- Info Role -->
  <div class="px-3 py-2 mt-4">
    <small class="text-white-50">Login sebagai:</small>
    <div class="badge bg-light text-primary w-100 mt-1">
      {{ Auth::user()->role->display_name }}
    </div>
  </div>

 
</div>

<style>

  
        .bubbles {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
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

        .bubble:nth-child(1) {
            width: 90px;
            height: 90px;
            left: 8%;
            bottom: -100px;
            animation-duration: 12s;
            animation-delay: 0s;
            background: radial-gradient(circle at 30% 30%, rgba(52, 152, 219, 0.6), rgba(255, 154, 86, 0.4));
        }

        .bubble:nth-child(2) {
            width: 60px;
            height: 60px;
            left: 22%;
            bottom: -80px;
            animation-duration: 14s;
            animation-delay: 2s;
            background: radial-gradient(circle at 30% 30%, rgba(100, 181, 246, 0.5), rgba(255, 167, 38, 0.3));
        }

        .bubble:nth-child(3) {
            width: 45px;
            height: 45px;
            left: 42%;
            bottom: -60px;
            animation-duration: 10s;
            animation-delay: 4s;
        }

        .bubble:nth-child(4) {
            width: 75px;
            height: 75px;
            left: 58%;
            bottom: -90px;
            animation-duration: 13s;
            animation-delay: 1s;
            background: radial-gradient(circle at 30% 30%, rgba(66, 165, 245, 0.55), rgba(255, 183, 77, 0.35));
        }

        .bubble:nth-child(5) {
            width: 50px;
            height: 50px;
            left: 73%;
            bottom: -70px;
            animation-duration: 11s;
            animation-delay: 3s;
        }

        .bubble:nth-child(6) {
            width: 85px;
            height: 85px;
            left: 88%;
            bottom: -95px;
            animation-duration: 15s;
            animation-delay: 0.5s;
            background: radial-gradient(circle at 30% 30%, rgba(41, 128, 185, 0.6), rgba(255, 193, 7, 0.4));
        }

        .bubble:nth-child(7) {
            width: 55px;
            height: 55px;
            left: 12%;
            bottom: -75px;
            animation-duration: 12.5s;
            animation-delay: 2.5s;
        }

        .bubble:nth-child(8) {
            width: 65px;
            height: 65px;
            left: 35%;
            bottom: -85px;
            animation-duration: 13.5s;
            animation-delay: 1.8s;
            background: radial-gradient(circle at 30% 30%, rgba(30, 136, 229, 0.5), rgba(255, 160, 0, 0.35));
        }

        .bubble:nth-child(9) {
            width: 70px;
            height: 70px;
            left: 65%;
            bottom: -80px;
            animation-duration: 11.5s;
            animation-delay: 3.5s;
        }

        .bubble:nth-child(10) {
            width: 40px;
            height: 40px;
            left: 80%;
            bottom: -60px;
            animation-duration: 10.5s;
            animation-delay: 4.5s;
        }

.sidebar {
  width: 240px;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  background: linear-gradient(135deg, #F5A83B 30%, #F5C16B 100%,);
  color: #fff;
  padding-top: 1rem;
  z-index: 1000;
  display: flex;
  flex-direction: column;
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
</style>
