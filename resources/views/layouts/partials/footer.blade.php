<footer class="bg-darkblue text-white py-3 mt-auto">
    <div class="container-fluid text-center">
        <small>&copy; {{ date('Y') }} TapEats System. All Rights Reserved. | 
            <i class="bi bi-person-fill me-1"></i> User: 
            @if(Auth::check()) 
                {{ Auth::user()->username }} ({{ ucwords(Auth::user()->role) }})
            @else
                Guest
            @endif
        </small>
    </div>
</footer>