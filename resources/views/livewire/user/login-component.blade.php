<div>
    <div class="modal-header border-0 px-8">
        <h5 class="modal-title">Sign In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body p-4 py-sm-7 px-sm-8">
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form wire:submit.prevent="loginn" class="form">
            <div class="form-group mb-4">
                <label for="phone_number" class="sr-only">Phone Number</label>
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                            <i class="far fa-phone"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control border-0 shadow-none fs-13" id="phone_number" name="phone_number" required placeholder="Phone number" wire:model.defer="phone_number">
                </div>
            </div>
            
            <div class="form-group mb-4">
                <label for="password" class="sr-only">Password</label>
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-gray-01 border-0 text-muted fs-18">
                            <i class="far fa-lock"></i>
                        </span>
                    </div>
                    <input type="password" class="form-control border-0 shadow-none fs-13" id="password" name="password" required placeholder="Password" wire:model.defer="password">
                    <div class="input-group-append">
                        <span class="input-group-text bg-gray-01 border-0 text-body fs-18" id="togglePassword" style="cursor: pointer;">
                            <i class="far fa-eye-slash"></i>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="d-flex mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="remember-me" name="remember" wire:model.defer="remember">
                    <label class="form-check-label" for="remember-me">
                        Remember me
                    </label>
                </div>
                <a href="/forgot-password" class="d-inline-block ml-auto text-orange fs-15">
                    Lost password?
                </a>
            </div>
        
            <button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
        </form>        
    </div>
</div>
