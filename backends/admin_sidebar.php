<div class="sidebar" id="sidebar">

    <div class="sidebar-brand">
        <div>
            <div class="brand-wordmark">Real<span>Estate</span></div>
            <div class="brand-sub">Admin Panel</div>
        </div>
    </div>

    <div class="sidebar-nav">

        <div class="nav-item active">
            <a href="../admin_side/index.php">
                <i class="fa fa-chart-line nav-icon"></i> Dashboard
            </a>
        </div>

     <div class="nav-item" id="propertyDropdown">
    <a href="javascript:void(0);" id="dropdownToggle">
        <i class="fa fa-home nav-icon"></i> Properties
        <i class="fa fa-chevron-down arrow"></i>
    </a>

    <div class="dropdown-menu">
        <a href="../backends/add-property.php">Add Property</a>
        <a href="../admin_side/update_properties.php">Update Property</a>
    </div>
</div>

        <div class="nav-item">
            <a href="admin_blog_management.php">
                <i class="fa fa-blog nav-icon"></i> Blogs
            </a>
        </div>

        <div class="nav-item">
            <a href="logout.php">
                <i class="fa fa-sign-out nav-icon"></i> Logout
            </a>
        </div>

    </div>
</div>

<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div><script>
function toggleDropdown() {
    document.getElementById("propertyMenu").classList.toggle("show");
}
</script>