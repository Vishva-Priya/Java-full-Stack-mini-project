package com.linkedin.dao;

import com.linkedin.model.Post;
import com.linkedin.util.DatabaseConnection;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class PostDAO {
    
    public boolean createPost(Post post) {
        String sql = "INSERT INTO posts (user_id, content) VALUES (?, ?)";
        try (Connection conn = DatabaseConnection.getConnection();
             PreparedStatement pstmt = conn.prepareStatement(sql)) {
            
            pstmt.setInt(1, post.getUserId());
            pstmt.setString(2, post.getContent());
            
            return pstmt.executeUpdate() > 0;
        } catch (SQLException e) {
            return false;
        }
    }
    
    public List<Post> getAllPosts() {
        List<Post> posts = new ArrayList<>();
        String sql = "SELECT p.*, u.first_name, u.last_name, u.headline " +
                    "FROM posts p JOIN users u ON p.user_id = u.id " +
                    "ORDER BY p.created_at DESC";
        
        try (Connection conn = DatabaseConnection.getConnection();
             PreparedStatement pstmt = conn.prepareStatement(sql)) {
            
            ResultSet rs = pstmt.executeQuery();
            while (rs.next()) {
                Post post = new Post();
                post.setId(rs.getInt("id"));
                post.setUserId(rs.getInt("user_id"));
                post.setContent(rs.getString("content"));
                post.setCreatedAt(rs.getTimestamp("created_at"));
                post.setAuthorName(rs.getString("first_name") + " " + rs.getString("last_name"));
                post.setAuthorHeadline(rs.getString("headline"));
                posts.add(post);
            }
        } catch (SQLException e) {
        }
        return posts;
    }
    
    public List<Post> getPostsByUserId(int userId) {
        List<Post> posts = new ArrayList<>();
        String sql = "SELECT p.*, u.first_name, u.last_name, u.headline " +
                    "FROM posts p JOIN users u ON p.user_id = u.id " +
                    "WHERE p.user_id = ? ORDER BY p.created_at DESC";
        
        try (Connection conn = DatabaseConnection.getConnection();
             PreparedStatement pstmt = conn.prepareStatement(sql)) {
            
            pstmt.setInt(1, userId);
            ResultSet rs = pstmt.executeQuery();
            
            while (rs.next()) {
                Post post = new Post();
                post.setId(rs.getInt("id"));
                post.setUserId(rs.getInt("user_id"));
                post.setContent(rs.getString("content"));
                post.setCreatedAt(rs.getTimestamp("created_at"));
                post.setAuthorName(rs.getString("first_name") + " " + rs.getString("last_name"));
                post.setAuthorHeadline(rs.getString("headline"));
                posts.add(post);
            }
        } catch (SQLException e) {
        }
        return posts;
    }
}
