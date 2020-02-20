Moodle Block Remote Content
===================================

A generic primitive to embed some arbitrary content comming from a Web Service
access to a remote application.

=== Data sources ===

the Web service can be Rest or Soap, and is supposed returning :

- Raw content that can be displayed directely in the block surface or with some CSS rules applied
- JSON daa structures that may be injected into a presentation template.

there should be provision for an alternative request that gets a short version of the content when
main request is displayed in a separate page or in a lightbox. In case such alternate definition exists
the short content will be displayed above the link for accessing the full content.

=== Service call parametrization ===

The service call may be fixed by the central definition (administrator scope), or may accept some
contextual variability. The query string (or soap parameter description) should thus accept a
filtering/replace processing to inject some contextual available information into the
output parameters :

- User ID (discouraged)
- Username
- User ID Number
- Current Course shortname
- Current Course IDNumber
- Current Course ID (discouraged)

If the authtype is 'sitetoken', the unique central site token is injected into the
output params formula. the site token is stored into the data source descriptor.

If the authtype is set to 'instancetoken' mode, the teacher can enter a token into the
block instance settings that will be injected in the output params. The instance token 
is stored into the block local instance configuration.

If the authtype is set to 'usertoken' mode, the end user will be able to input a personal 
token (from a link in the footer) for his own use. The user token will be stored into the 
user's preferences referencing the block instance.

=== Source management ===

Site Administrator only sources : Some sources can only be setup by an administrator.

Site Shared (capability driven) sources : Site shared sources can be invoked in a block by any 
people having the capability in the block context.

User sources : People with capability of managing sources will be able to store new sources
and use them in the blocks they setup.

=== Output display ===

The output may be displayed : 

- in the block area
- in a separate page
- in a lightbox popup on the current page