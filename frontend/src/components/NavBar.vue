<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" style="color: #4e290f; font-weight: 1000;" href="#">Online-Library</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/home" style="color: #4e290f; font-weight: 1000;">Book Store</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/userpro"><img src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" alt="Profile" class="rounded-circle" width="30" height="30"></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</template>

<script>
export default{
    name:'NavBar',
}
</script>