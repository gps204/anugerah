import './bootstrap';
import './admin/sidebar';

// jQuery and other libraries like DataTables are loaded via CDN in the main layout (admin.blade.php).
// Importing them here again via Vite would cause conflicts.
// This file should only contain application-specific JS that depends on those global libraries.
