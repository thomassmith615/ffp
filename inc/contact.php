<?php
/**
 * Contact form AJAX handler (action: fortune_contact).
 * Nonce-verified, sanitized, delivered via wp_mail() with Reply-To.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

function ffp_handle_contact_form() {
	check_ajax_referer( 'fortune_nonce', 'nonce' );

	$first   = sanitize_text_field( $_POST['first_name'] ?? '' );
	$last    = sanitize_text_field( $_POST['last_name'] ?? '' );
	$email   = sanitize_email( $_POST['email'] ?? '' );
	$phone   = sanitize_text_field( $_POST['phone'] ?? '' );
	$topic   = sanitize_text_field( $_POST['topic'] ?? '' );
	$message = sanitize_textarea_field( $_POST['message'] ?? '' );

	if ( empty( $email ) || ! is_email( $email ) ) {
		wp_send_json_error( [ 'message' => 'Please provide a valid email address.' ] );
	}

	$to      = get_option( 'admin_email' );
	$subject = "New Contact Form Submission: {$topic}";
	$body    = "Name: {$first} {$last}\nEmail: {$email}\nPhone: {$phone}\nTopic: {$topic}\n\nMessage:\n{$message}";
	$headers = [
		'Content-Type: text/plain; charset=UTF-8',
		"Reply-To: {$first} {$last} <{$email}>",
	];

	if ( wp_mail( $to, $subject, $body, $headers ) ) {
		wp_send_json_success( [ 'message' => "Thank you, {$first}! We'll be in touch shortly." ] );
	}

	wp_send_json_error( [ 'message' => 'There was an issue sending your message. Please call us directly at (856) 454-5005.' ] );
}
add_action( 'wp_ajax_fortune_contact', 'ffp_handle_contact_form' );
add_action( 'wp_ajax_nopriv_fortune_contact', 'ffp_handle_contact_form' );

/**
 * CCPA privacy request form (action: fortune_privacy) — the
 * /do-not-sell/ page. Emails the request to the site admin.
 */
function ffp_handle_privacy_form() {
	check_ajax_referer( 'fortune_nonce', 'nonce' );

	$name    = sanitize_text_field( $_POST['name'] ?? '' );
	$email   = sanitize_email( $_POST['email'] ?? '' );
	$message = sanitize_textarea_field( $_POST['message'] ?? '' );

	$requests = array_filter( array_map( 'sanitize_text_field', (array) ( $_POST['requests'] ?? [] ) ) );

	if ( empty( $email ) || ! is_email( $email ) ) {
		wp_send_json_error( [ 'message' => 'Please provide a valid email address.' ] );
	}
	if ( empty( $requests ) ) {
		wp_send_json_error( [ 'message' => 'Please select at least one request type.' ] );
	}

	$to      = get_option( 'admin_email' );
	$subject = 'Privacy Request (CCPA)';
	$body    = "Name: {$name}\nEmail: {$email}\n\nRequested:\n- " . implode( "\n- ", $requests ) . "\n\nMessage:\n{$message}";
	$headers = [
		'Content-Type: text/plain; charset=UTF-8',
		"Reply-To: {$name} <{$email}>",
	];

	if ( wp_mail( $to, $subject, $body, $headers ) ) {
		wp_send_json_success( [ 'message' => "Your request has been received. We'll follow up at {$email}." ] );
	}

	wp_send_json_error( [ 'message' => 'There was an issue sending your request. Please call us at (856) 454-5005.' ] );
}
add_action( 'wp_ajax_fortune_privacy', 'ffp_handle_privacy_form' );
add_action( 'wp_ajax_nopriv_fortune_privacy', 'ffp_handle_privacy_form' );
