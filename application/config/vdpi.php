<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  VDPI Admin Menu
* 
* Author: Ben Edmunds
* 	  ben.edmunds@gmail.com
*         @benedmunds
*          
* Added Awesomeness: Phil Sturgeon
* 
* Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth/
*          
* Created:  10.01.2009 
* 
* Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
* Original Author name has been kept but that does not mean that the method has not been modified.
* 
*/

	/**
	 * VDPI Menu Tables.
	 **/
	$config['vdpi_protocol_menu'] = array(
		'webs'=>array(
			'title'=>'HTTP',
			'table'=>'webs',
			'columns'=>array(
				'Time'=>'capture_date',
				'Host'=>'host',		 	 	 	 	 	 	 
				'Content Type'=>'content_type', 	 	 	 	 	 	 
				'URL'=>'url'
			)
		),
		'arps'=>array(
			'title'=>'ARP',
			'table'=>'arps',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',		 	 	 	 	 	 	 
				'MAC'=>'mac', 	 	 	 	 	 	 
				'IP Address'=>'ip'
			)
		),
		'dns_messages'=>array(
			'title'=>'DNS',
			'table'=>'dns_messages',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',		 	 	 	 	 	 	 
				'Important'=>'important', 	 	 	 	 	 	 
				'Host Name'=>'hostname', 	 	 	 	 	 	 
				'CNAME'=>'cname', 	 	 	 	 	 	 
				'IP Address'=>'ip'
			)
		),
		'ftps'=>array(
			'title'=>'FTP',
			'table'=>'ftps',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'URL'=>'url',
				'Important'=>'important',
				'Username'=>'username',
				'Password'=>'password',
				'Command Path'=>'cmd_path',
				'Upload'=>'upload_num',
				'Download'=>'download_num'
			)
		),
		'icmpv6s'=>array(
			'title'=>'IPv6',
			'table'=>'icmpv6s',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'MAC'=>'mac',
				'IP'=>'ip'
			)
		),
		'emails'=>array(
			'title'=>'Email',
			'table'=>'emails',
			'columns'=>array(
				'Time'=>'capture_date',
				'Size'=>'data_size',
				'Flow'=>'flow_info',
				'Receive'=>'receive',
				'Relevance'=>'relevance',
				'Comments'=>'comments',
				'Username'=>'username',
				'Password'=>'password',
				'Sender'=>'sender',
				'Receiver'=>'receivers',
				'Subject'=>'subject',
				'MIME Path'=>'mime_path',
				'Attach'=>'attach_dir'
			)
		),
		'ircs'=>array(
			'title'=>'IRC',
			'table'=>'ircs',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'URL'=>'url',
				'Important'=>'important',
				'Command Path'=>'cmd_path',
				'Channel Number'=>'channel_num'
			)
		),
		'irc_channels'=>array(
			'title'=>'IRC Channel',
			'table'=>'irc_channels',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'Channel'=>'channel',
				'End Date'=>'end_date',
				'Channel Path'=>'channel_path',
				'CUser'=>'cusers',
				'CNick'=>'cnick'
			)
		),
		'rtps'=>array(
			'title'=>'RTP',
			'table'=>'rtps',
			'columns'=>array(
				'Time'=>'capture_date',
				'Size'=>'data_size',
				'Flow'=>'flow',
				'From Address'=>'from_addr',
				'To Address'=>'to_addr',
				'User Caller'=>'ucaller',
				'User Called'=>'ucalled',
				'User Mix'=>'umix',
				'Duration'=>'duration'
			)
		),		
		'sips'=>array(
			'title'=>'SIP',
			'table'=>'sips',
			'columns'=>array(
				'Time'=>'capture_date',
				'Size'=>'data_size',
				'Flow'=>'flow_info',
				'Command'=>'commands',
				'From Address'=>'from_addr',
				'To Address'=>'to_addr',
				'User Caller'=>'ucaller',
				'User Called'=>'ucalled',
				'User Mix'=>'umix',
				'Duration'=>'duration'
			)
		),
		/*
		'sources'=>array(
			'title'=>'Source',
			'table'=>'sources',
			'columns'=>array(
				'IP'=>'ip',
				'Name'=>'name'
			)
		),
		*/
		'telnets'=>array(
			'title'=>'Telnet',
			'table'=>'telnets',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'Important'=>'important',
				'Hostname'=>'hostname',
				'Username'=>'username',
				'Password'=>'password',
				'Command'=>'cmd',
				'Command Size'=>'cmd_size'
			)
		),
		'tftps'=>array(
			'title'=>'TFTP',
			'table'=>'tftps',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'URL'=>'url',
				'Important'=>'important',
				'Command Path'=>'cmd_path',
				'Upload'=>'upload_num',
				'Download'=>'download_num'
			)
		),
		'mms'=>array(
			'title'=>'MMS',
			'table'=>'mms',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'URL'=>'url',
				'From'=>'from_num',
				'To'=>'to_num',
				'CC'=>'cc_num',
				'BCC'=>'bcc_num',
				'Content'=>'contents'
			)
		),
	);

	$config['vdpi_content_menu']  = array(
		'ftp_files'=>array(
			'title'=>'FTP File',
			'table'=>'ftp_files',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'File Name'=>'filename',
				'File Path'=>'file_path',
				'File Size'=>'file_size',
				'File Percentual'=>'file_percentual',
				'Info Part'=>'info_part',
				'Downloaded'=>'downloaded',
				'Hole'=>'hole',
				'Complete'=>'complete'
			)
		),
		'httpfiles'=>array(
			'title'=>'HTTP File',
			'table'=>'httpfiles',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'Important'=>'important',
				'URL'=>'url',
				'Content Type'=>'content_type',
				'File Path'=>'file_path',
				'File Name'=>'file_name',
				'File Size'=>'file_size',
				'File Part'=>'file_parts',
				'File Status'=>'file_stat'
			)
		),
		'tftp_files'=>array(
			'title'=>'TFTP File',
			'table'=>'tftp_files',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'File Name'=>'filename',
				'File Path'=>'file_path',
				'File Size'=>'file_size',
				'File Percentual'=>'file_percentual',
				'Info Part'=>'info_part',
				'Downloaded'=>'downloaded',
				'Hole'=>'hole',
				'Complete'=>'complete'
			)
		),		
		'mmscontents'=>array(
			'title'=>'MMS Content',
			'table'=>'mmscontents',
			'columns'=>array(
				'Content Type'=>'content_type',
				'File Name'=>'filename',
				'File Path'=>'file_path',
				'File Size'=>'file_size'
			)
		),
		'nntp_articles'=>array(
			'title'=>'NNTP Articles',
			'table'=>'nntp_articles',
			'columns'=>array(
				'Time'=>'capture_date',
				'Size'=>'data_size',
				'Flow'=>'flow_info',
				'Receive'=>'receive',
				'Important'=>'important',
				'Body'=>'only_body',
				'Sender'=>'sender',
				'Receiver'=>'receivers',
				'Subject'=>'subject',
				'MIME Path'=>'mime_path'
			)
		),
		'nntp_groups'=>array(
			'title'=>'NNTP Group',
			'table'=>'nntp_groups',
			'columns'=>array(
				'Name'=>'name'
			)
		),
		
		
	);

	
	$config['vdpi_application_menu']  = array(
		'fbchats'=>array(
			'title'=>'Facebook',
			'table'=>'fbchats',
			'columns'=>array(
				'Time'=>'capture_date',
				'Size'=>'data_size',
				'Flow'=>'flow_info',
				'Important'=>'important',
				'User'=>'user',
				'Friend'=>'friend',
				'Chat'=>'chat',
				'Duration'=>'duration'
			)
		),
		'feeds'=>array(
			'title'=>'Feed',
			'table'=>'feeds',
			'columns'=>array(
				'Name'=>'name',
				'Site'=>'site'
			)
		),
		'feed_xmls'=>array(
			'title'=>'Feed XML',
			'table'=>'feed_xmls',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'URL'=>'url',
				'Response Header'=>'rs_header',
				'Response Body'=>'rs_body',
				'Response Body Size'=>'rs_bd_size'
			)
		),
		/*'inputs'=>array(
			//'title'=>'Input',
			//'table'=>'inputs',
			//'columns'=>array(
				//'Start Time'=>'start_time',
				//'End Time'=>'end_time',
				//'Size'=>'data_size',
				'File Name'=>'file_name',
				'MD5'=>'md5',
				'SHA1'=>'sha1',
			)
		),*/
		'msn_chats'=>array(
			'title'=>'MSN',
			'table'=>'msn_chats',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'Chat'=>'chat',
				'End Date'=>'end_date',
				'Chat Path'=>'chat_path',
				'Duration'=>'duration'
			)
		),
		'paltalk_exps'=>array(
			'title'=>'Paltalk Exp',
			'table'=>'paltalk_exps',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'User Nick'=>'user_nick',
				'End Date'=>'end_date',
				'Channel Path'=>'channel_path'
			)
		),
		'paltalk_rooms'=>array(
			'title'=>'Paltalk',
			'table'=>'paltalk_rooms',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'Room'=>'room',
				'End Date'=>'end_date',
				'Room Path'=>'room_path',
				'Duration'=>'duration',
				'RUser'=>'rusers',
				'RNick'=>'rnick'
			)
		),
		'pjls'=>array(
			'title'=>'Printer',
			'table'=>'pjls',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'URL'=>'url',
				'PDF Path'=>'pdf_path',
				'PDF Size'=>'pdf_size',
				'PCL Path'=>'pcl_path',
				'PCL Size'=>'pcl_size',
				'Error'=>'error'
			)
		),
		/*'scripts_users'=>array(
			'title'=>'Report Recipient',
			'table'=>'scripts_users',
			'columns'=>array(
				'Script ID'=>'script_id',
				'User ID'=>'user_id'
			)
		),*/

		/*
		'thresholds'=>array(
			'title'=>'Threshold',
			'table'=>'thresholds',
			'columns'=>array(
				'Threshold Name'=>'threshold_name',
				'App'=>'app',
				'Parameter'=>'parameter',
				'Min'=>'min',
				'Max'=>'max'
			)
		),
		'threshold_users'=>array(
			'title'=>'Report Recipient',
			'table'=>'thresholds_users',
			'columns'=>array(
				'Threshold Name'=>'threshold_id',
				'Username'=>'user_id'
			)
		),
		'unknows'=>array(
			'title'=>'Unknown',
			'table'=>'unknows',
			'columns'=>array(
				'Time'=>'capture_date',
				'Flow'=>'flow_info',
				'Important'=>'important',
				'Destination'=>'dst',
				'Destination Portocol'=>'dst',
				'L7 Protocol'=>'l7prot',
				'File Path'=>'file_path',
				'Duration'=>'duration',
				'Size'=>'size'
			)
		),
		'Users'=>array(
			'title'=>'User',
			'table'=>'users',
			'columns'=>array(
				'Username'=>'username',
				'Email'=>'email',
				'First Name'=>'first_name',
				'Last Name'=>'last_name',
				'Last Login'=>'last_login',
				'Group'=>'group_id'
			)
		),
		*/
		'webmails'=>array(
			'title'=>'Webmail',
			'table'=>'webmails',
			'columns'=>array(
				'Time'=>'capture_date',
				'Size'=>'data_size',
				'Flow'=>'flow_info',
				'Receive'=>'receive',
				'Relevance'=>'relevance',
				'Service'=>'service',
				'Sender'=>'sender',
				'Receiver'=>'receivers',
				'CC Receiver'=>'cc_receivers',
				'Subject'=>'subject',
				'MIME Path'=>'mime_path',
				'Text Path'=>'txt_path',
				'HTML Path'=>'html_path',
				'EType'=>'etype'
			)
		),
	);

	
/* End of file vdpi.php */
/* Location: ./system/application/config/vdpi.php */