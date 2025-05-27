// Navbar notifications dropdown
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM loaded, initializing dropdowns...');
  
  var dropdown_triggers = document.querySelectorAll("[dropdown-trigger]");
  console.log('Found dropdown triggers:', dropdown_triggers.length);
  
  dropdown_triggers.forEach((dropdown_trigger) => {
    let dropdown_menu = dropdown_trigger.parentElement.querySelector("[dropdown-menu]");
    console.log('Dropdown menu found:', !!dropdown_menu);
    
    if (!dropdown_menu) {
      console.error('Dropdown menu not found for trigger:', dropdown_trigger);
      return;
    }

    // Set initial state
    dropdown_menu.classList.add("opacity-0", "pointer-events-none", "transform-dropdown");
    dropdown_trigger.setAttribute("aria-expanded", "false");

    // Add click event to trigger
    dropdown_trigger.onclick = function(e) {
      console.log('Dropdown clicked');
      e.preventDefault();
      e.stopPropagation();
      
      // Toggle classes
      dropdown_menu.classList.toggle("opacity-0");
      dropdown_menu.classList.toggle("pointer-events-none");
      dropdown_menu.classList.toggle("before:-top-5");
      
      // Toggle aria-expanded
      const isExpanded = dropdown_trigger.getAttribute("aria-expanded") === "true";
      dropdown_trigger.setAttribute("aria-expanded", !isExpanded);
      
      // Toggle transform classes
      if (!isExpanded) {
        dropdown_menu.classList.remove("transform-dropdown");
        dropdown_menu.classList.add("transform-dropdown-show");
      } else {
        dropdown_menu.classList.remove("transform-dropdown-show");
        dropdown_menu.classList.add("transform-dropdown");
      }
    };

    // Close dropdown when clicking outside
    document.addEventListener("click", function (e) {
      if (!dropdown_menu.contains(e.target) && !dropdown_trigger.contains(e.target)) {
        if (dropdown_trigger.getAttribute("aria-expanded") === "true") {
          dropdown_trigger.click();
        }
      }
    });
  });
});
