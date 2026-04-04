@foreach($users as $user)

<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Edit User</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-body">

          <div class="mb-3">
            <label>User Name</label>
            <input type="text" name="name"
                   class="form-control"
                   value="{{ $user->name }}" required>
          </div>

          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email"
                   class="form-control"
                   value="{{ $user->email }}" required>
          </div>

          <div class="mb-3">
            <label>New Password (optional)</label>
            <input type="password" name="password"
                   class="form-control"
                   placeholder="Leave empty if not changing">
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>

      </form>

    </div>
  </div>
</div>

@endforeach
