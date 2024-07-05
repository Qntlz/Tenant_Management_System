<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<?php
    session_start();
    // print_r($_SESSION);
?>

<head>
    <script src="../../assets/dist/js/color-modes.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Browse Apartments | C-Apartments</title>
    <link rel="icon" href="../../assets/src/svg/c-logo.svg">

    <link rel="stylesheet" href="../../assets/dist/css/bootstrap.min.css">
    <link href="../../assets/src/css/themes.css" rel="stylesheet">
</head>

<style>
    .glass-navbar {
        background: rgba(0, 0, 0, 0.3); /* White background with 70% opacity */
        backdrop-filter: blur(0.5px); /* Blur effect */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }
    #banner {
        max-height: 50px; /* Minimized logo size */
        transition: 0.8s; /* Smooth transition */
    }
    .thumbnail { 
        display:block; 
        z-index:999; 
        cursor: pointer; 
        -webkit-transition-property: all; 
        -webkit-transition-duration: 0.3s; 
        -webkit-transition-timing-function: ease; 
    } 
    /*change the number below to scale to the appropriate size*/ 
    .thumbnail:hover { 
        transform: scale(1.01); 
    }
</style>

<body class="bg-body-tertiary">
    <?php include ('../../core/themes.php') ?>
    <?php include ('../../core/database.php') ?>

    <?php
    // Fetch apartment data from the database
    $sql = "SELECT apartmentNumber, apartmentType, rentPerMonth, apartmentPictures, apartmentStatus FROM apartment ORDER BY apartmentStatus";
    $result = $conn->query($sql);

    $apartments = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $apartments[] = $row;
        }
    }
    $conn->close();
    ?>

    <nav class="navbar navbar-light fixed-top justify-content-center align-items-center glass-navbar">
        <a class="navbar-brand logo" href="landing.php">
            <img id="banner" src="../../assets/src/svg/c.svg" alt="Website Logo" class="img-fluid">
        </a>
    </nav>

    <main class="container-xl container mt-3 pt-3 px-0">

        <div class="container pb-4" style="padding-top: 65px; ">
            <div class="text-center">
                <span class="">
                    <a href="../../views/common/landing.php" class="text-decoration-none text-secondary" title="Back to landing page">Home</a> / 
                    <span class="text-secondary">Browse</span>
                </span>
            </div>
        </div>
        
    <div class="container">
        <div class="row mb-3">
            <div class="col-12">
                <input type="text" class="form-control" id="filterInput" placeholder="Filter apartments...">
            </div>
        </div>
        <div class="row" id="apartmentGrid">
            <!-- Apartment cards will be dynamically inserted here -->
        </div>
    </div>
</main>

<script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const apartments = <?php echo json_encode($apartments); ?>;

    function createApartmentCard(apartment) {
        // Determine the status message
        let statusMessage = '';
        if (apartment.apartmentStatus === 'available') {
            statusMessage = '<div class="p-3 mb-2 text-success-emphasis text-end">Available</div>';
        } else if (apartment.apartmentStatus === 'unavailable') {
            // Assuming you want the date the apartment will be available
            let availableDate = new Date();
            availableDate.setMonth(availableDate.getMonth() + 1); // Example: setting available date to one month later
            statusMessage = `<div class="p-3 mb-2 text-danger-emphasis text-end">Available by ${availableDate.toISOString().split('T')[0]}</div>`;
            statusMessage = `<div class="p-3 mb-2 text-danger-emphasis text-end">Unavailable</div>`;
        } else {
            statusMessage = 'unknown status';
        }

        const cardBgClass = apartment.apartmentStatus === 'available' ? 'bg-success-subtle' : 'bg-danger-subtle';

        return `
            <div class="col-md-4 mb-4">
                <div class="card bg-transparent thumbnail shadow ${cardBgClass}">
                    <a href="apartment.php?apartment=${apartment.apartmentNumber}" style="text-decoration: none;">
                        <img src="../../${apartment.apartmentPictures}" class="card-img-top" alt="${apartment.apartmentType}">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title">${apartment.apartmentType}</h5>
                                        <p class="card-text">₱${Number(apartment.rentPerMonth).toFixed(2)} / month</p>
                                    </div>
                                    <div class="col-md-6">
                                        ${statusMessage}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        `;
    }

    function loadApartments() {
        const apartmentGrid = document.getElementById('apartmentGrid');
        apartmentGrid.innerHTML = apartments.map(createApartmentCard).join('');
    }

    document.addEventListener('DOMContentLoaded', loadApartments);
</script>
    <script>
        // Function to handle scroll event
        window.addEventListener('scroll', function() {
            var banner = document.getElementById('banner');
            var navbar = document.getElementsByClassName('glass-navbar')[0]; // Select the first element

            if (window.scrollY > 80) {
                banner.style.maxHeight = '35px'; // Adjusted size when scrolled down
                // navbar.style.background = 'none'; // Remove background when scrolled down
                navbar.style.backdropFilter = 'none'; // Remove backdrop filter when scrolled down
                navbar.style.boxShadow = 'none'; // Remove box shadow when scrolled down
            } else {
                banner.style.maxHeight = '50px'; // Default size when not scrolled down
                navbar.style.background = 'rgba(0, 0, 0, 0.3)'; // Default background color
                navbar.style.backdropFilter = 'blur(0.5px)'; // Restore backdrop filter when not scrolled down
                navbar.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)'; // Restore box shadow when not scrolled down
            }
        });
    </script>
</body>
</html>