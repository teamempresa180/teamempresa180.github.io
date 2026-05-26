import os

files_to_update = ['index.php', 'contacto.php', 'nosotros.php', 'unidades.php']

old_js = """      function submitToCRM(e) {
        e.preventDefault();
        const name = document.getElementById('crm-name').value;
        const email = document.getElementById('crm-email').value;
        const message = document.getElementById('crm-message').value;
        
        // Save to LocalStorage Database
        const DB_KEY = '180_crm_leads';
        const leads = JSON.parse(localStorage.getItem(DB_KEY) || '[]');
        leads.push({
          id: 'lead_' + Date.now(),
          name: name,
          email: email,
          message: message,
          source: 'Web Grupo Empresarial',
          status: 'nuevos',
          date: new Date().toLocaleDateString()
        });
        localStorage.setItem(DB_KEY, JSON.stringify(leads));
        
        // Show success
        document.getElementById('crm-success-msg').style.display = 'block';
        document.getElementById('crm-contact-form').reset();
        setTimeout(() => {
           document.getElementById('crm-success-msg').style.display = 'none';
        }, 4000);
      }"""

new_js = """      async function submitToCRM(e) {
        e.preventDefault();
        const name = document.getElementById('crm-name').value;
        const email = document.getElementById('crm-email').value;
        const message = document.getElementById('crm-message').value;
        
        const data = {
          name: name,
          email: email,
          message: message,
          source: 'Web Grupo Empresarial'
        };

        try {
          const response = await fetch('api/leads.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
          });
          
          if (response.ok) {
            document.getElementById('crm-success-msg').style.display = 'block';
            document.getElementById('crm-contact-form').reset();
            setTimeout(() => {
               document.getElementById('crm-success-msg').style.display = 'none';
            }, 4000);
          } else {
            console.error('Error saving lead');
          }
        } catch (err) {
          console.error(err);
        }
      }"""

for filename in files_to_update:
    filepath = os.path.join(".", filename)
    if os.path.exists(filepath):
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        
        new_content = content.replace(old_js, new_js)
        
        if content != new_content:
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(new_content)
            print(f"Updated {filepath}")
    else:
        print(f"File {filepath} not found")

print("Done updating form JS.")
