package com.linkedin.dao;

import com.linkedin.model.Connection;
import com.linkedin.util.DatabaseConnection;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class ConnectionDAO {

    public boolean sendConnectionRequest(int requesterId, int addresseeId) {
        String sql = "INSERT INTO connections (requester_id, addressee_id) VALUES (?, ?)";

        try (java.sql.Connection conn = DatabaseConnection.getConnection();
             PreparedStatement pstmt = conn.prepareStatement(sql)) {

            pstmt.setInt(1, requesterId);
            pstmt.setInt(2, addresseeId);

            return pstmt.executeUpdate() > 0;

        } catch (SQLException e) {
            handleSQLException(e, "Failed to send connection request");
            return false;
        }
    }

    public boolean updateConnectionStatus(int connectionId, String status) {
        String sql = "UPDATE connections SET status = ? WHERE id = ?";

        try (java.sql.Connection conn = DatabaseConnection.getConnection();
             PreparedStatement pstmt = conn.prepareStatement(sql)) {

            pstmt.setString(1, status);
            pstmt.setInt(2, connectionId);

            return pstmt.executeUpdate() > 0;

        } catch (SQLException e) {
            handleSQLException(e, "Failed to update connection status");
            return false;
        }
    }

    public List<Connection> getPendingConnections(int userId) {
        List<Connection> connections = new ArrayList<>();
        String sql = "SELECT c.*, u1.first_name AS req_fname, u1.last_name AS req_lname, " +
                "u2.first_name AS addr_fname, u2.last_name AS addr_lname " +
                "FROM connections c " +
                "JOIN users u1 ON c.requester_id = u1.id " +
                "JOIN users u2 ON c.addressee_id = u2.id " +
                "WHERE c.addressee_id = ? AND c.status = 'pending'";

        try (java.sql.Connection conn = DatabaseConnection.getConnection();
             PreparedStatement pstmt = conn.prepareStatement(sql);
             ResultSet rs = executeQuery(pstmt, userId)) {

            while (rs.next()) {
                connections.add(mapConnection(rs));
            }

        } catch (SQLException e) {
            handleSQLException(e, "Failed to retrieve pending connections");
        }

        return connections;
    }

    public List<Connection> getAcceptedConnections(int userId) {
        List<Connection> connections = new ArrayList<>();
        String sql = "SELECT c.*, u1.first_name AS req_fname, u1.last_name AS req_lname, " +
                "u2.first_name AS addr_fname, u2.last_name AS addr_lname " +
                "FROM connections c " +
                "JOIN users u1 ON c.requester_id = u1.id " +
                "JOIN users u2 ON c.addressee_id = u2.id " +
                "WHERE (c.requester_id = ? OR c.addressee_id = ?) AND c.status = 'accepted'";

        try (java.sql.Connection conn = DatabaseConnection.getConnection();
             PreparedStatement pstmt = conn.prepareStatement(sql);
             ResultSet rs = executeQuery(pstmt, userId, userId)) {

            while (rs.next()) {
                connections.add(mapConnection(rs));
            }

        } catch (SQLException e) {
            handleSQLException(e, "Failed to retrieve accepted connections");
        }

        return connections;
    }

    private ResultSet executeQuery(PreparedStatement pstmt, int... params) throws SQLException {
        for (int i = 0; i < params.length; i++) {
            pstmt.setInt(i + 1, params[i]);
        }
        return pstmt.executeQuery();
    }

    private Connection mapConnection(ResultSet rs) throws SQLException {
        Connection connection = new Connection();
        connection.setId(rs.getInt("id"));
        connection.setRequesterId(rs.getInt("requester_id"));
        connection.setAddresseeId(rs.getInt("addressee_id"));
        connection.setStatus(rs.getString("status"));
        connection.setCreatedAt(rs.getTimestamp("created_at"));
        connection.setRequesterName(rs.getString("req_fname") + " " + rs.getString("req_lname"));
        connection.setAddresseeName(rs.getString("addr_fname") + " " + rs.getString("addr_lname"));
        return connection;
    }

    private void handleSQLException(SQLException e, String message) {
        System.err.println(message + ": " + e.getMessage());
        // Log the exception or handle it as per your application's requirements
    }
}
