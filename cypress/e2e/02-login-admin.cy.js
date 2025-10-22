describe('Prodmais - Login e Área Administrativa', () => {
  beforeEach(() => {
    cy.visit('/login.php');
  });

  it('Deve exibir a tela de login', () => {
    cy.contains('Login').should('be.visible');
    cy.get('input[name="username"]').should('be.visible');
    cy.get('input[name="password"]').should('be.visible');
    cy.screenshot('06-tela-login', {
      capture: 'fullPage',
      overwrite: true
    });
  });

  it('Deve fazer login com sucesso', () => {
    cy.get('input[name="username"]').type(Cypress.env('adminUser'));
    cy.get('input[name="password"]').type(Cypress.env('adminPassword'));
    cy.get('button[type="submit"]').click();
    cy.wait(1000);
    cy.screenshot('07-login-sucesso', {
      capture: 'fullPage',
      overwrite: true
    });
  });

  it('Deve acessar área administrativa', () => {
    // Fazer login primeiro
    cy.get('input[name="username"]').type(Cypress.env('adminUser'));
    cy.get('input[name="password"]').type(Cypress.env('adminPassword'));
    cy.get('button[type="submit"]').click();
    cy.wait(1000);
    
    // Acessar admin
    cy.visit('/admin.php');
    cy.wait(2000);
    cy.screenshot('08-area-administrativa', {
      capture: 'fullPage',
      overwrite: true
    });
  });

  it('Deve visualizar upload de arquivos', () => {
    // Fazer login
    cy.get('input[name="username"]').type(Cypress.env('adminUser'));
    cy.get('input[name="password"]').type(Cypress.env('adminPassword'));
    cy.get('button[type="submit"]').click();
    cy.wait(1000);
    
    cy.visit('/admin.php');
    cy.wait(1000);
    cy.contains('Upload').click({ force: true });
    cy.wait(1000);
    cy.screenshot('09-upload-arquivos', {
      capture: 'fullPage',
      overwrite: true
    });
  });
});
