<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session()->has('success'))
<script>
Swal.fire({
  icon: "success",
  title: "Success",
  text: "{{ session('success') }}",
  timer: 3000,
  timerProgressBar: true
})
</script>

@elseif (session()->has('success2'))
<script>
Swal.fire({
  icon: "success",
  title: "Success",
  text: "{{ session('success2') }}",
})
</script>

@elseif (session()->has('info'))
<script>
Swal.fire({
  icon: "info",
  title: "Info",
  text: "{{ session('info') }}",
  timer: 3000,
  timerProgressBar:true,
})
</script>

@elseif (session()->has('warning'))
<script>
Swal.fire({
  icon: "warning",
  title: "Warning",
  text: "{{ session('warning') }}",
})
</script>

@elseif (session()->has('error'))
<script>
Swal.fire({
  icon: "error",
  title: "Ups...",
  text: "{{ session('error') }}",
})
</script>
@endif