---

title: 'Pipe SMS: An Open-Source Web and Android-Based Messaging and Automation Platform'
tags:
  - SMS Automation
  - Messaging Platform
  - Web Application
  - Android Application
  - Open Source
  - PHP
  - Java
  - Laravel
  - REST API
  - Bulk Messaging
authors:
  - name: Elijah Edward Masanga
    orcid: 0000-0003-2397-9680
    corresponding: true
    affiliation: "1"
affiliations:
  - name: Damotiva Enterprises, Mbeya, Tanzania
    index: 1
date: 2 October 2025
bibliography: paper.bib

---

# Summary

* This paper introduces *Pipe SMS*, an open-source messaging platform for web and Android applications developed at *Damotiva Enterprises*. It enables large-scale, reliable SMS communication and integrates backend services for account management, reporting, and automation\[@pipesms2025]\[@alves2021scalable]\[@chen2020bulk].

* Key features include:

  * **Web-based management**: Centralized dashboard for monitoring and sending SMS\[@smith2021opensource]
  * **Bulk SMS sending**: Efficient handling of large messaging campaigns\[@chen2020bulk]\[@brown2019sms]
  * **REST API support**: Seamless integration with external systems\[@liu2019api]
  * **Database integration**: PhpMyAdmin support for data management\[@kumar2020laravel]
  * **Cross-platform support**: Web and Android clients\[@jones2018android]

# Statement of Need

## Problem

* Organizations, researchers, and SMEs require scalable SMS systems for:

  * Notifications and alerts\[@alves2021scalable]
  * Two-factor authentication (2FA)\[@singh2022security]
  * Surveys and data collection\[@chen2020bulk]
  * Marketing campaigns\[@chen2020bulk]

* Existing solutions are often expensive, closed-source, or inflexible, limiting customization\[@smith2021opensource].

## Solution

* *Pipe SMS* provides a self-hosted, open-source solution with:

  * Web and Android interfaces for sending and tracking messages\[@jones2018android]
  * Secure login and user account management\[@singh2022security]
  * Extensible REST API endpoints\[@liu2019api]
  * Bulk SMS delivery with detailed reporting\[@brown2019sms]\[@miller2021automation]

# Technical Implementation

* *Pipe SMS* uses PHP and Laravel for backend management and Java for Android, with a modular architecture separating core messaging, database interaction, and interfaces\[@kumar2020laravel]\[@jones2018android].

## Architecture

* Components:

  * **Dashboard Module**: Web interface for SMS management\[@smith2021opensource]
  * **API Module**: REST endpoints for integration\[@liu2019api]
  * **Database Module**: PhpMyAdmin integration\[@kumar2020laravel]
  * **Android Client Module**: SMS sending and account management\[@jones2018android]

* ![Pipe SMS Architecture](Pics/pipesms_logo.webp)

## Installation

* Clone the repository:

  ```bash
  git clone https://github.com/masangaeli/pipesms.git
  cd pipesms
  ```
* Follow repository setup instructions for web and Android components.

## Demo Credentials

* **Pipe SMS Dashboard**

  * Username: `admin@damotiva.com`
  * Password: `0p9o8i`

* **PhpMyAdmin**

  * Username: `pipeg_user`
  * Password: `Ks5ZuLg5OTdwQ6r6`

> *Note: Update credentials for production deployments.*
