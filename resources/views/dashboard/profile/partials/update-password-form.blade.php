<h5 class="card-header">{{ __('dashboard/profile/edit.password_header') }}</h5>
<div class="card-body">
    <form id="formAccountDeactivation" action="{{ route('dashboard.password.update') }}" method="post">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="mb-3">
                <label for="current_password" class="form-label">{{ __('dashboard/profile/edit.current_password') }}</label>
                <input class="form-control" type="password" id="current_password" name="current_password"/>

                <x-input-error-with-bag  bag-name="updatePassword" key="current_password" />
            </div>

            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">{{ __('dashboard/profile/edit.new_password') }}</label>
                <input class="form-control" type="password" id="password" name="password"/>

                <x-input-error-with-bag  bag-name="updatePassword" key="password" />
            </div>
            <div class="mb-3 col-md-6">
                <label for="password_confirmation" class="form-label">{{ __('dashboard/profile/edit.confirm_new_password') }}</label>
                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation"/>


                <x-input-error-with-bag  bag-name="updatePassword" key="password_confirmation" />
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('dashboard/profile/edit.save_new_password_button') }}</button>
    </form>
</div>
