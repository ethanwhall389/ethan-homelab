# Windows Server Active Directory Lab

![alt text](screenshots/active-directory.png)

## Overview

The objective of this home lab was to create a Windows server that functions as a Domain Controller for a local network to run the Active Directory service to local devices.

Requirements:

- Use virtualization to create a Windows server
- Set up windows server as a domain controller
- Create mock users and groups within Active Directory
- Configure a client machine to connect to the Domain Controller
- Apply Group Policies (password rules, drive mapping, lock screen policies)
- Practice resetting passwords and managing permissions

## Technologies Used

Windows Server, Active Directory, VirtualBox

## Build Journal

### 1. Installing Windows Server in VirtualBox

Each section should contain steps taken, why certain decisions were made, screenshots, problems and fixes, outcome.

- Downloaded the official Windows Server 2025 ISO from Microsoft.
- Created a new VirtualBox VM and went through the typical Windows Server install
  - Chose to use the Desktop Experience version of Windows Server to allow for simpler management of Active Directory services.

### 2. Standard Windows Server Setup

- Renamed the PC (server) to a sensible name.
- Configured Windows updates to ensure server is fully patched, updated, and secure.
- Enabled remote management through Server Manager.

### 3. Promoting Windows Server as a Domain Controller, installing Active Directory

- Installed Active Directory Domain Services through the Server Manager.
  - Add roles and features > Active Directory Domain Services.
  - Promoted to a domain controller after install finished.
    - Created a new forest and created the root domain name for the domain controller server.

### 4. Setting up Active Directory and the Domain Controller

- Changed the domain controller's IP address to a static IP.
- Changed the domain controller's DNS to be self-referential (loopback address).
- In Active Directory Users and Groups created simple OUs (Organizational Units)
  - Created Users and Computers OUs inside a top-level USA OU.
    - In Users, created IT, HR, and Accounting OUs.
    - Created a few dummy users.

### 4. Installing Windows 11 in VirtualBox, connect to Domain Controller

- Created a new VirtualBox VM and went through the typical Windows 11 Pro install.
- Using the IP address assigned to the Domain Controller, assigned it as the DNS server for the new client machine.
- Pinging the Domain Controller worked as expected.
- ❌Performing an nslookup of the Domain Controller's domain did not work properly. Constantly returned a "non-existent domain" error.
  - Spent large amount of time troubleshooting. Made sure Active Directory was installed properly and that the proper SRV records were configured in DNS Manager on the Domain Controller.
  - Eventually realized that the VMs were both using NAT mode, which gave them both identical local IP addresses. Switched to "Bridged" mode, which made both VMs an independent device on the LAN, assigning unique IPs to each.
  - Reconfigured the IP and DNS for both devices. Still recieved the same error of "non-existent domain".
  - Realized that in performing the nslookup, the client device was referencing the local router for DNS, instead of the Domain Controller. This was because both the client and Domain Controller were learning and preferring IPv6 DNS servers from the router, even though IPv6 was turned off in settings.
  - The fix was to completely disable IPv6 on the NIC of both devices through the Network and Sharing Center.

### 5. Applying Group Policies

### 6. SysAdmin Practice

- Resetting pwds, managing permissions. . .

## Wrap up Thoughts
