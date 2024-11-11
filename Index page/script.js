function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('open'); // Toggle the 'open' class
  }
  
  // close button functionality
  const closeButtonSidebar = document.querySelector('.sidebar-close');
  closeButtonSidebar.addEventListener('click', () => {
    sidebar.classList.remove('open'); 
  });
  