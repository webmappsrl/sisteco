describe('Login Sisteco', () => {

    it('Login Mario Pestarini', () => {
        cy.visit('/nova/login')
        cy.get('input[name=email]').type('mario.pestarini@timesis.it')
        cy.get('input[name=password]').type('timesisteco')
        cy.get('button').contains('Login').click()
        cy.url().should('contain', '/')

        cy.get('span.text-90').click()
        cy.contains('Logout').click()

    })

    it('Login Fabrizio Cassi', () => {
        cy.visit('/nova/login')
        cy.get('input[name=email]').type('fabrizio.cassi@timesis.it')
        cy.get('input[name=password]').type('timesisteco')
        cy.get('button').contains('Login').click()
        cy.url().should('contain', '/')

        cy.get('span.text-90').click()
        cy.contains('Logout').click()

    })

    it('Login Leonardo Pugliesi', () => {
        cy.visit('/nova/login')
        cy.get('input[name=email]').type('leonardo.pugliesi@timesis.it')
        cy.get('input[name=password]').type('timesisteco')
        cy.get('button').contains('Login').click()
        cy.url().should('contain', '/')

        cy.get('span.text-90').click()
        cy.contains('Logout').click()

    })
    it('Login Anna Chiara Lorenzelli', () => {
        cy.visit('/nova/login')
        cy.get('input[name=email]').type('ac.lorenzelli@timesis.it ')
        cy.get('input[name=password]').type('timesisteco')
        cy.get('button').contains('Login').click()
        cy.url().should('contain', '/')

        cy.get('span.text-90').click()
        cy.contains('Logout').click()

    })

    it('Login Enrico Quaglino', () => {
        cy.visit('/nova/login')
        cy.get('input[name=email]').type('enrico.quaglino@timesis.it')
        cy.get('input[name=password]').type('timesisteco')
        cy.get('button').contains('Login').click()
        cy.url().should('contain', '/')

        cy.get('span.text-90').click()
        cy.contains('Logout').click()

    })

    it('Login Mauro Piazzi', () => {
        cy.visit('/nova/login')
        cy.get('input[name=email]').type('mauro.piazzi@timesis.it ')
        cy.get('input[name=password]').type('timesisteco')
        cy.get('button').contains('Login').click()
        cy.url().should('contain', '/')

        cy.get('span.text-90').click()
        cy.contains('Logout').click()

    })

    it('Login Webmapp Team', () => {
        cy.visit('/nova/login')
        cy.get('input[name=email]').type('team@webmapp.it')
        cy.get('input[name=password]').type('timesisteco')
        cy.get('button').contains('Login').click()
        cy.url().should('contain', '/')

        cy.get('span.text-90').click()
        cy.contains('Logout').click()

    })

})
