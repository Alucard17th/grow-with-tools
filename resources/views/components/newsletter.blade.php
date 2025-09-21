<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center g-3">
            <div class="col-lg-6">
                <h3 class="fw-bold mb-1">Join the updates</h3>
                <p class="text-secondary mb-0">Ship notes, new releases, and occasional tutorials.</p>
            </div>
            <div class="col-lg-6">
                <form class="d-flex gap-2 justify-content-lg-end" id="leadForm">
                    <input type="email" class="form-control" placeholder="you@example.com" id="email" required>
                    <input type="text" id="full_name" class="form-control" placeholder="Full name (optional)">
                    <button class="btn btn-primary">Subscribe</button>
                </form>
                <div class="success alert alert-success d-none mt-2 p-1"></div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('leadForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const full_name = document.getElementById('full_name').value;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    document.querySelector('.success').classList.add('d-none');

    const response = await fetch("{{ route('leads.js.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        },
        body: JSON.stringify({ email, full_name })
    });

    const result = await response.json();

    if(result.success) {
        document.querySelector('.success').classList.remove('d-none');
        document.querySelector('.success').innerHTML = result.message;
        document.getElementById('leadForm').reset();
    } else {
        alert('Error: ' + (result.message || 'Please check your input'));
    }
});
</script>