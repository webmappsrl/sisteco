describe('Login Sisteco', () => {


    it('Button', () => {
        cy.visit('/nova/login')
        cy.get('input[name=email]').type('team@webmapp.it')
        cy.get('input[name=password]').type('timesisteco')
        cy.get('button').contains('Login').click()
        cy.url().should('contain', '/')

        cy.get('#nova > div > div.content > div.px-view.py-view.mx-auto > div:nth-child(2) > div:nth-child(3) > div:nth-child(2) > div:nth-child(1) > div > div > table > tbody > tr:nth-child(1) > td.td-fit.text-right.pr-6 > span > a > svg').click()

        cy.url().should('contain', '/nova/resources/maps/')

        cy.wait(3000);

        cy.get('span.text-90').click()
        cy.contains('Logout').click()

    })

})
