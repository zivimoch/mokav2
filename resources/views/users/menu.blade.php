<a href="{{ route('users.show', Auth::user()->uuid) }}" class="list-group-item list-group-item-action flex-column align-items-start"> 
    <div class="d-flex"> 
        <small class="mr-2">
            <i class="fas fa-users-cog"></i>
        </small> 
        <h6 style="margin-bottom: -2px">
            User Settings    
        </h6>
    </div> 
</a>
<a href="{{ route('users.websettings', Auth::user()->uuid) }}" class="list-group-item list-group-item-action flex-column align-items-start"> 
    <div class="d-flex"> 
        <small class="mr-2">
            <i class="fas fa-cogs"></i>
        </small> 
        <h6 style="margin-bottom: -2px">
            Web Settings    
        </h6>
    </div> 
</a>