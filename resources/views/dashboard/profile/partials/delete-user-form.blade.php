<h5 class="card-header">{{ __('dashboard/profile/edit.delete_profile_header') }}</h5>
<div class="card-body">
    <div class="mb-3 col-12 mb-0">
        <div class="alert alert-warning">
            <h6 class="alert-heading fw-bold mb-1">{{ __('dashboard/profile/edit.warning_header') }}</h6>
            <p class="mb-0">{{ __('dashboard/profile/edit.warning_body') }}</p>
        </div>
    </div>

{{--    @dd($errors->userDeletion->first('password'))--}}

    <x-input-error-with-bag bag-name="userDeletion" key="password" />

    <button type="button" class="btn btn-danger mt-1" data-bs-toggle="modal" data-bs-target="#modalCenter">
        {{ __('dashboard/profile/edit.delete_profile_button') }}
    </button>


    <!-- Modal -->
    <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="modalCenterTitle">{{ __('dashboard/profile/edit.warning_header') }}</h5>
                        <p class="mb-0 mt-2">{{ __('dashboard/profile/edit.warning_body') }}</p>
                    </div>
                    <button type="button" class="btn-close" title="{{ __('dashboard/profile/edit.cancel') }}" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('dashboard.profile.destroy') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="password" class="form-label">{{ __('dashboard/profile/edit.password') }}</label>
                                <input type="password" id="password" class="form-control"
                                       name="password"
                                       placeholder="{{ __('dashboard/profile/edit.password') }}">

                                <x-input-error-with-bag bag-name="userDeletion" key="password" />

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">{{ __('dashboard/profile/edit.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-danger">{{ __('dashboard/profile/edit.delete_profile_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
