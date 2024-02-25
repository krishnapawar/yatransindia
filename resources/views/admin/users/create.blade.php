@extends('layouts.app',['pageTitle'=>'Add User'])
@section('content_header')
<div class="col-md-6 text-end">
    <a href="{{route('users.index')}}" class="btn btn-outline-primary">Back</a>
</div>
@endsection
@section('content')
<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <div id="profile_picture_preview" class="mt-2">
            <img id="profile_picture_preview_img" src="https://via.placeholder.com/150" alt="Profile Preview" class="img-fluid rounded-circle">
        </div>
        <div class="custom-file">
            <input type="file" name="profile_picture" id="profile_picture_input" class="custom-file-input" accept="image/jpeg, image/png, image/jpg, image/gif">
            <label class="custom-file-label" for="profile_picture_input">Choose file</label>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="col-md-6 form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="col-md-6 form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6 form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control numeric-input" pattern="\d+" required>
        </div>
        <div class="col-md-6 form-group">
            <label for="gender">Gender</label>
            <select name="gender" class="form-control" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="col-md-6 form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control" required>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>
        </div>
    </div>

    <!-- Address fields -->
    <div id="addresses-container">
        <div class="address-group">
            <h2>Address 1</h2>
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="addresses[0][country]">Country</label>
                    <input type="text" name="addresses[0][country]" class="form-control" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="addresses[0][city]">City</label>
                    <input type="text" name="addresses[0][city]" class="form-control" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="addresses[0][state]">State</label>
                    <input type="text" name="addresses[0][state]" class="form-control" required>
                </div>
                <div class="col-md-6 form-group">
                    <label for="addresses[0][zip_code]">ZIP Code</label>
                    <input type="text" name="addresses[0][zip_code]" class="form-control numeric-input" pattern="\d+" required>
                </div>
                <div class="col-md-12 form-group">
                    <label for="addresses[0][address_line]">Address Line</label>
                    <input type="text" name="addresses[0][address_line]" class="form-control" required>
                </div>
            </div>
            <button type="button" class="btn btn-danger remove-address mt-1" onclick="removeAddress(this)">Remove Address</button>
        </div>
    </div>

    <button type="button" class="btn btn-primary mt-2" onclick="addAddress()">Add More Address</button>

    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>
   
@endsection
@section('script')
    <script>
        function addAddress() {
            var container = document.getElementById('addresses-container');
            var groupCount = container.querySelectorAll('.address-group').length;
            var newGroup = container.querySelector('.address-group').cloneNode(true);

            newGroup.querySelector('h2').innerText = 'Address ' + (groupCount + 1);

            // Update input names to avoid conflicts
            newGroup.querySelectorAll('input').forEach(function (input) {
                var name = input.getAttribute('name');
                name = name.replace(/\[(\d+)\]/g, '[' + (groupCount + 1) + ']');
                input.setAttribute('name', name);
            });

            // Clear values in the new group
            newGroup.querySelectorAll('input').forEach(function (input) {
                input.value = '';
            });

            container.appendChild(newGroup);
            hideFirstIndex();
        }
        hideFirstIndex();

        function removeAddress(button) {
            var container = document.getElementById('addresses-container');
            var group = button.closest('.address-group');

            if (container.childElementCount > 1) {
                container.removeChild(group);
            } else {
                group.querySelectorAll('input').forEach(function (input) {
                    input.value = '';
                });
            }
            hideFirstIndex();
        }

        function hideFirstIndex() {
            var buttons = document.querySelectorAll('.remove-address');

            buttons.forEach(function (btn, index) {
                if (index === 0) {
                    btn.style.display = 'none';
                } else {
                    btn.style.display = 'block';
                }
            });
        }


        document.getElementById('profile_picture_input').addEventListener('change', function(event) {
            var input = event.target;
            var preview = document.getElementById('profile_picture_preview_img');
            var label = document.querySelector('.custom-file-label');

            var reader = new FileReader();
            reader.onload = function() {
                preview.src = reader.result;
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
                label.innerText = input.files[0].name;
            }
        });
        document.getElementById('profile_picture_preview').addEventListener('click', function() {
            document.getElementById('profile_picture_input').click();
        });
    </script>
@endsection
