@extends('layouts.admin')

@section('content')


    @section('content')
        <div class="container">
            <h1 class="dashboard-title">Admin Dashboard</h1>

            <!-- İstatistik Bölümü -->
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-card-icon"><i class="fas fa-users"></i></div>
                    <h2>Total Admins</h2>
                    <p>{{ $adminCount }}</p>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon"><i class="fas fa-cogs"></i></div>
                    <h2>Total Products</h2>
                    <p>{{ $productCount }}</p>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon"><i class="fas fa-box"></i></div>
                    <h2>Total Orders</h2>
                    <p>{{ $orderCount }}</p>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon"><i class="fas fa-users"></i></div>
                    <h2>Total Users</h2>
                    <p>{{ $usersCount }}</p>
                </div>
            </div>

            <!-- Bağlantılar Bölümü -->
            <div class="links">
                <a href="{{ route('admin.users') }}" class="btn btn-primary">Manage Users</a>
                <a href="{{ route('admin.orders') }}" class="btn btn-primary">Manage Orders</a>
                <a href="{{ route('admin.products') }}" class="btn btn-primary">Manage Products</a>
            </div>
        </div>
    @endsection


