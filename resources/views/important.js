<div class="form-group">
  <label class="form-label">Favicon<span class="text-red">*</span></label>
  <input type="file" onchange="document.getElementById('favicon').src=window.URL.createObjectURL(this.files[0])" name="favicon" class="form-control">
  @error('favicon')
      <span class="text-danger">{{ $message }}</span>
  @enderror
</div>

<div class="form-group">
    <label for="form-label"></label>
    <img width="100px" height="100px" id="favicon" class="img-responsive br-5" src="{{ url('backend/assets/uploads/settings/default.jpg') }}" >
</div>
