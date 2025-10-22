describe('Prodmais - Busca de Pesquisadores', () => {
  beforeEach(() => {
    cy.visit('/');
  });

  it('Deve buscar pesquisadores', () => {
    cy.contains('Pesquisadores').click();
    cy.wait(1000);
    cy.screenshot('10-busca-pesquisadores', {
      capture: 'fullPage',
      overwrite: true
    });
  });

  it('Deve exibir perfil de pesquisador', () => {
    cy.contains('Pesquisadores').click();
    cy.wait(1000);
    cy.get('input[type="text"]').first().type('Silva');
    cy.get('button').contains('Buscar').click();
    cy.wait(2000);
    cy.screenshot('11-perfil-pesquisador', {
      capture: 'fullPage',
      overwrite: true
    });
  });
});
