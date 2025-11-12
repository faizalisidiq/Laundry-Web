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

    @if (auth()->user()->isAdmin())
        <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
        🔐 Kelola Role
        </a>
    @endif

  <hr class="my-2" style="border-color: rgba(255,255,255,0.2);">

  <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf
    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
      🚪 Logout
    </a>
  </form>
</div>



  <!-- Info Role -->
  <div class="px-3 py-2 mt-4">
    <small class="text-white-50">Login sebagai:</small>
    <div class="badge bg-light text-primary w-100 mt-1">
      {{ Auth::user()->role->display_name }}
    </div>
  </div>

  <!-- Logout -->
  <form action="{{ route('logout') }}" method="POST" class="mt-auto">
    @csrf
    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="text-danger">
      🚪 Logout
    </a>
  </form>
</div>

<style>
.sidebar {
  width: 240px;
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  background: linear-gradient(180deg, #0d6efd 0%, #0a58ca 100%);
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
