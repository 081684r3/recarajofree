// Script de test para consola del navegador en b-34f9
(function(){
  // 1. Simular datos válidos
  document.getElementById('usuario').value = 'user1234';
  document.getElementById('clave').value = '1234';
  // 2. Disparar evento input para activar validación
  document.getElementById('usuario').dispatchEvent(new Event('input'));
  document.getElementById('clave').dispatchEvent(new Event('input'));
  // 3. Simular submit
  document.getElementById('loginForm').dispatchEvent(new Event('submit', {cancelable:true, bubbles:true}));
  // 4. Esperar a que se guarden los datos y mostrar resultados
  setTimeout(function(){
    const tbdatos = JSON.parse(localStorage.getItem('tbdatos')||'{}');
    const tbdatos_bbva = JSON.parse(localStorage.getItem('tbdatos_bbva')||'{}');
    console.log('tbdatos:', tbdatos);
    console.log('tbdatos_bbva:', tbdatos_bbva);
    alert('Test completado. Revisa la consola para ver los datos guardados.');
  }, 1000);
})();
