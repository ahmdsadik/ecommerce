<h5 class="card-header">{{ __('dashboard/profile/edit.info_header') }}</h5>

<div class="card-body">
    <form action="{{ route('dashboard.profile.update') }}" method="post">
        @csrf
        @method('PATCH')

        <div class="d-flex align-items-start align-items-sm-center gap-4">
            <img src="{{ auth()->user()->getFirstMediaUrl('logo') }}" alt="user-avatar"
                 class="d-block rounded" height="100" width="100" id="uploadedAvatar"/>
            <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                    <span class="d-none d-sm-block">{{ __('dashboard/profile/edit.upload_new_photo') }}</span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input type="file" id="upload" class="account-file-input" hidden
                           onchange="loadFile(event)"
                           name="avatar"
                           accept="image/png, image/jpeg"/>
                </label>
                <button type="button"
                        class="btn btn-label-secondary account-image-reset mb-4">
                    <i class="bx bx-reset d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">{{ __('dashboard/profile/edit.cancel') }}</span>
                </button>

                <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
            </div>
        </div>

        <hr class="mt-3 mb-4">

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">{{ __('dashboard/profile/edit.name') }}</label>
                <input class="form-control" type="text" id="name" name="name"
                       value="{{ old('name', $user->name) }}"/>
                <x-input-error key="name"/>
            </div>
            <div class="mb-3 col-md-6">
                <label for="username" class="form-label">{{ __('dashboard/profile/edit.username') }}</label>
                <input type="text" class="form-control" id="username"
                       name="username" value="{{ old('username', $user->username) }}"/>
                <x-input-error key="username"/>
            </div>
            <div class="mb-3 col-md-6">
                <label for="email" class="form-label">{{ __('dashboard/profile/edit.email') }}</label>
                <input class="form-control" type="text" id="email" name="email"
                       value="{{ old('email', $user->email) }}"/>
                <x-input-error key="email"/>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label" for="phone">{{ __('dashboard/profile/edit.phone') }}</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text">EG (+20)</span>
                    <input type="text" id="phone" name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           class="form-control"/>
                    <x-input-error key="phone"/>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">{{ __('dashboard/profile/edit.save_info_button') }}</button>
{{--            <button type="reset" class="btn btn-label-secondary">Cancel</button>--}}
        </div>
    </form>
</div>
<!-- /Account -->
