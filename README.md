# DRGERP

# What is DRGERP?

**Drugs Shop ERP** is an open source project based on **PHP** & **Bootstrap**, including a **web** based **shop** + backend **ERP** for orders, products, warehouses.

The **ERP** contains all the features you’ll need to manage your company, just create a database following the given **SQL** structure, and **manually** register your employes.

Customers can register themself using the provided registration form.

The application uses **MySQL** database + **PHP** code, **Bootstrap** for the graphics.

Works best on **PC** platform.

**Web Demo:** [https://labs3.fauser.edu/~web11956/ERP/](https://labs3.fauser.edu/~web11956/ERP/)

**Contact** : @emikodes @CANEPAZZOSSIMO

**The web client is an experimental educational project, we don’t recommend relying on it if you’re a company, but has a solid structure and you can use parts of the code as you prefer.**

---

# Configuration:

## MySQL Database:

1. Install **MySQL** Version 8.0+
2. Import the database (Couple of products, warehouses, orders and users are already inserted for experimental projects)
3. The import process will create the required “erp_azienda” schema.

You shouldn’t change the database structure if you don’t also modify the **PHP** code.

There’s a configuration file under the “/config” directory you have to modify according to your server settings (hostname, username, password, Database name).

---

# Application:

---

## Index page:

- Multiple drug categories available
- Shopping cart link
- Login page link

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled.png)

---

## Product page:

- Choose quantity and click on “Aggiungi al carrello” to add it to the cart.
- Custom icons for each product.

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%201.png)

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%202.png)

---

## Shopping cart:

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%203.png)

All the products you insert in your cart will be shown here.

- **“Svuota il carrello”** button, to empty the cart.
- **“Acquista”** button to complete your order.
    
    To buy products, you have to be logged in as **USER**, otherwise an informative message will be shown.
    
    ![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%204.png)
    

If you’re already signed in, the order will be completed and sent to the company.

---

## Registration form:

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%205.png)

From this page, you can register yourself as a customer.

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%206.png)

Every input has been checked, you can choose not to specify a home address, and pick up your order locally at the warehouse.

You also can’t register your email more than once.

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%207.png)

Once you register, a verification email will be sent.

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%208.png)

If you try logging in without verifying your email, another warning message will be shown:.

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%209.png)

---

## Verification email:

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2010.png)

Click on the button to verify your email.

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2011.png)

Now you can log-in by clicking on the green button.

---

## User Login Page:

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2012.png)

A Warning message will be shown if the mail or password is wrong, a different one will be shown if the mail is not registered at all.

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2013.png)

Once you’ve logged in, you can buy products from the index (shop) page.

---

## Employee Login page:

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2014.png)

You’ll have to manually register your employees via SQL “INSERT” statements.

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2015.png)

Every employee dashboard has been protected, and you can’t access it if you’re not logged in.

---

## Dashboards:

![chrome-capture-2023-3-20.gif](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/chrome-capture-2023-3-20.gif)

From the main dashboard, you’ll see a brief summary of the last orders, products available quantity, warehouse situation (products in it, space available)

In the left navbar, you can access multiple specific dashboards, to manage products, customers or orders.

---

### Products dashboard:

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2016.png)

Here you can see every product listed in the shop, prices, quantity available, earinings.

Clicking on the green button you can add a new product to sell.

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2017.png)

Or you can click on the blue button to modify an existing one

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2018.png)

Or press on the red one to delete one.

> NOTE: if you try to order more than your warehouse maximum capacity, a warning message will be shown and the modify won’t be applied:
> 

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2019.png)

---

### Orders dashboard:

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2020.png)

---

### Customers dashboard:

![Untitled](DRGERP%20f661b8ba262d4549abb8a4afc51152c0/Untitled%2021.png)

---

# EMPLOYEE DEMO CREDENTIALS:

**EMAIL:** emailDipendente@dipendente.it

**PASSWORD:** passwordAdmin