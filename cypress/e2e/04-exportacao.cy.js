describe('Prodmais - Exportação de Dados', () => {
  beforeEach(() => {
    cy.visit('/');
  });

  it('Deve exibir opções de exportação', () => {
    cy.get('input[type="text"]').first().type('artigo');
    cy.get('button').contains('Buscar').click();
    cy.wait(2000);
    
    cy.contains('Exportar').click();
    cy.wait(500);
    cy.screenshot('12-opcoes-exportacao', {
      capture: 'viewport',
      overwrite: true
    });
  });

  it('Deve filtrar por tipo de publicação', () => {
    cy.contains('Filtros').click();
    cy.wait(500);
    cy.get('select[name="type"]').select('Artigo');
    cy.wait(1000);
    cy.screenshot('13-filtro-tipo', {
      capture: 'fullPage',
      overwrite: true
    });
  });

  it('Deve filtrar por ano', () => {
    cy.contains('Filtros').click();
    cy.wait(500);
    cy.get('input[name="year_from"]').type('2020');
    cy.get('input[name="year_to"]').type('2024');
    cy.get('button').contains('Aplicar').click();
    cy.wait(2000);
    cy.screenshot('14-filtro-ano', {
      capture: 'fullPage',
      overwrite: true
    });
  });
});
